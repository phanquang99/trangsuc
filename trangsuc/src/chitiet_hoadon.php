<?php

namespace CT275\Labs;

class chitiet_hoadon
{
	private $db;

	private $id = -1;
	public $soluong;
	public $tong_giatri;
	public $id_hd;
	public $id_sp;
	private $errors = [];

	public function getId()
	{
		return $this->id;
	}

	public function __construct($pdo)
	{
		$this->db = $pdo;
	}

	public function fill(array $data)
	{
		if (isset($data['soluong'])) {
			$this->soluong = trim($data['soluong']);
		}

		if (isset($data['tong_giatri'])) {
			$this->tong_giatri = trim($data['tong_giatri']);
		}

		if (isset($data['id_hd'])) {
			$this->id_hd = trim($data['id_hd']);
		}
		if (isset($data['id_sp'])) {
			$this->id_sp = trim($data['id_sp']);
		}

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->name) {
			$this->errors['name'] = 'Invalid name.';
		}

		if (strlen($this->phone) < 10 || strlen($this->phone) > 11) {
			$this->errors['phone'] = 'Invalid phone number.';
		}

		if (strlen($this->notes) > 255) {
			$this->errors['notes'] = 'Notes must be at most 255 characters.';
		}

		return empty($this->errors);
	}

	public function all()
	{
		$chitiet_hoadons = [];
		$stmt = $this->db->prepare('select * from chitiet_hoadon');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$chitiet_hoadon = new chitiet_hoadon($this->db);
			$chitiet_hoadon->fillFromDB($row);
			$chitiet_hoadons[] = $chitiet_hoadon;
		}
		return $chitiet_hoadons;
	}
	protected function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'soluong' => $this->soluong,
			'tong_giatri' => $this->tong_giatri,
			'id_hd' => $this->id_hd,
			'id_sp' => $this->id_sp

		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id_hd >= 0) {
			$stmt = $this->db->prepare('update chitiet_hoadon set soluong = :soluong,
tong_giatri = :tong_giatri, id_hd = :id_hd, id_sp = :id_sp
where id = :id_hd'); //xem lai
			$result = $stmt->execute([
				'soluong' => $this->soluong,
				'tong_giatri' => $this->tong_giatri,
				'id_hd' => $this->id_hd,
				'id_sp' => $this->id_sp
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into chitiet_hoadon (soluong, tong_giatri, id_hd, id_sp)
values (:soluong, :tong_giatri, :id_hd, :id_sp)'
			);
			$result = $stmt->execute([
				'soluong' => $this->soluong,
				'tong_giatri' => $this->tong_giatri,
				'id_hd' => $this->id_hd,
				'id_sp' => $this->id_sp
			]);
		}
		return $result;
	}
	public function save1()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update chitiet_hoadon set soluong = :soluong,
tong_giatri = :tong_giatri, id_hd = :id_hd, id_sp = :id_sp
where id = :id_hd'); //xem lai
			$result = $stmt->execute([
				'soluong' => $this->soluong,
				'tong_giatri' => $this->tong_giatri,
				'id_hd' => $this->id_hd,
				'id_sp' => $this->id_sp
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into chitiet_hoadon (soluong, tong_giatri, id_hd, id_sp)
values (:soluong, :tong_giatri, :id_hd, :id_sp)'
			);
			$result = $stmt->execute([
				'soluong' => $this->soluong,
				'tong_giatri' => $this->tong_giatri,
				'id_hd' => $this->id_hd,
				'id_sp' => $this->id_sp
			]);
		}
		return $result;
	}
	public function find($id)
	{
		$stmt = $this->db->prepare('select * from chitiet_hoadon where id = :id');
		$stmt->execute(['id' => $id]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}
	public function update(array $data)
	{
		$this->fill($data);
		if ($this->validate()) {
			return $this->save();
		}
		return false;
	}
	public function delete()
	{
		$stmt = $this->db->prepare('delete from chitiet_hoadon where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
	public function find_id_hd($id_hd)
	{
		$stmt = $this->db->prepare('select * from chitiet_hoadon where id_hd = :id_hd');
		$stmt->execute(['id_hd' => $id_hd]);
		if ($row = $stmt->fetch()) {
			$this->fillFromDB($row);
			return $this;
		}
		return null;
	}

	public function update_sp(array $data)
	{
		$this->fill($data);
		$result = false;
		$stmt = $this->db->prepare('update chitiet_hoadon set soluong = :soluong,
tong_giatri = :tong_giatri, id_hd = :id_hd, id_sp = :id_sp
where (id_hd = :id_hd and id_sp = :id_sp)'); //xem lai
		$result = $stmt->execute([
			'soluong' => $this->soluong,
			'tong_giatri' => $this->tong_giatri,
			'id_hd' => $this->id_hd,
			'id_sp' => $this->id_sp
		]);
		return $result;
	}
	public function add_sp()
	{
		$result = false;
		$stmt = $this->db->prepare(
			'insert into chitiet_hoadon (soluong, tong_giatri, id_hd, id_sp)
values (:soluong, :tong_giatri, :id_hd, :id_sp)'
		);
		$result = $stmt->execute([
			'soluong' => $this->soluong,
			'tong_giatri' => $this->tong_giatri,
			'id_hd' => $this->id_hd,
			'id_sp' => $this->id_sp
		]);
		return $result;
	}
}
