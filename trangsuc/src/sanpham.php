<?php

namespace CT275\Labs;

class sanpham
{
	private $db;

	private $id = -1;
	public $ten;
	public $gia;
	public $hinhanh;
	public $ngaynhap;
	public $gioitinh_sanpham;
	public $id_loai;
	public $ten_loai;
	public $id_nv;
	public $ten_nv;
	public $soluong;
	private $errors = [];

	public function getId()
	{
		return $this->id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data, $FILES)
	{

		$this->ten = trim($data['ten']);


		if (isset($data['gia'])) {
			$this->gia = $data['gia'];
		}

		if (isset($FILES['hinhanh'])) {
			$file = $FILES['hinhanh'];// lay file
			$this->hinhanh = $file['name'];// lay hinh anh
			if($data['gioitinh_sanpham']==1){
				move_uploaded_file($file['tmp_name'], 'images/sanpham/nam/' .$this->hinhanh);
			}
			else{
				move_uploaded_file($file['tmp_name'], 'images/sanpham/nu/' .$this->hinhanh);
			}
			
		}
		if (isset($data['gioitinh_sanpham'])) {
			$this->gioitinh_sanpham = $data['gioitinh_sanpham'];
		}
		if (isset($data['id_loai'])) {
			$this->id_loai =  preg_replace('/\D+/', '', $data['id_loai']);
		}
		if (isset($data['id_nv'])) {
			$this->id_nv =  preg_replace('/\D+/', '', $data['id_nv']);
		}
		if (isset($data['soluong'])) {
			$this->soluong = trim($data['soluong']);
		}

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->ten) {
			$this->errors['ten'] = 'Tên không hợp lệ.';
		}
		if (!$this->gia) {
			$this->errors['gia'] = 'Giá không hợp lệ.';
		}
		elseif($this->gia > 2000000){
			$this->errors['gia'] = 'Giá không thể lớn hơn 2.000.000vnđ.';
		}
		if ( !$this->hinhanh ) {
			$this->errors['hinhanh'] = 'Hình ảnh không hợp lệ.';
		}
		if (!$this->soluong ) {
			$this->errors['soluong'] = 'Số lượng không hôp lệ.';
		}
		elseif(($this->soluong) < 0 || ($this->soluong) > 500 ){
			$this->errors['soluong'] = 'Số lượng không được phép nhỏ hơn 0 và lớn hơn 500.';

		}
		return empty($this->errors);//
	}

	public function all()
	{
		$sanphams = [];
		$stmt = $this->db->prepare('select *  from (sanpham inner join loai_sanpham on sanpham.id_loai=loai_sanpham.id_loai) inner join nhanvien on sanpham.id_nv=nhanvien.id_nv');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$sanpham = new sanpham($this->db);
			$sanpham->fillFromDB($row);
			$sanphams[] = $sanpham;
		}
		return $sanphams;
	}
	public function order_by($order_by)
	{
		$sanphams = [];
		$stmt = $this->db->prepare('select *  from (sanpham inner join loai_sanpham on sanpham.id_loai=loai_sanpham.id_loai) inner join nhanvien on sanpham.id_nv=nhanvien.id_nv ORDER BY '.$order_by);
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$sanpham = new sanpham($this->db);
			$sanpham->fillFromDB($row);
			$sanphams[] = $sanpham;
		}
		return $sanphams;
	}
	protected function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'ten' => $this->ten,
			'gia' => $this->gia,
			'hinhanh' => $this->hinhanh,
			'ngaynhap' => $this->ngaynhap,
			'gioitinh_sanpham' => $this->gioitinh_sanpham,
			'id_loai' => $this->id_loai,
			'ten_loai' => $this->ten_loai,
			'id_nv' => $this->id_nv,
			'ten_nv' => $this->ten_nv,
			'soluong' => $this->soluong,

		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update sanpham set ten = :ten,
			gia = :gia, hinhanh = :hinhanh, gioitinh_sanpham = :gioitinh_sanpham,  id_loai = :id_loai, id_nv = :id_nv,
			soluong = :soluong, ngaynhap = now() where id = :id');
			$result = $stmt->execute([
				'ten' => $this->ten,
				'gia' => $this->gia,
				'hinhanh' => $this->hinhanh,
				'gioitinh_sanpham' => $this->gioitinh_sanpham,
				'id_loai' => $this->id_loai,
				'id_nv' => $this->id_nv,
				'soluong' => $this->soluong,
				'id' => $this->id
				
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into sanpham (ten, gia, hinhanh, gioitinh_sanpham, id_loai, id_nv, soluong, ngaynhap)
values (:ten, :gia, :hinhanh, :gioitinh_sanpham,:id_loai, :id_nv, :soluong, now())'
			);
			$result = $stmt->execute([
				'ten' => $this->ten,
				'gia' => $this->gia,
				'hinhanh' => $this->hinhanh,
				'gioitinh_sanpham' => $this->gioitinh_sanpham,
				'id_loai' => $this->id_loai,
				'id_nv' => $this->id_nv,
				'soluong' => $this->soluong
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId(); // lay id giao dich cuoi cung
			}
		}

		return $result;
	}
	public function find($id)
	{
		$stmt = $this->db->prepare('select *  from (sanpham inner join loai_sanpham on sanpham.id_loai=loai_sanpham.id_loai) inner join nhanvien on sanpham.id_nv=nhanvien.id_nv where id = :id');
		$stmt->execute(['id' => $id]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}
	public function update(array $data,$FILES)
	{
		$this->fill($data,$FILES);
		
		if ($this->validate()) {
			return $this->save();
		}
		return false;
		
	
	}
	public function delete()
	{
		$stmt = $this->db->prepare('delete from sanpham where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
