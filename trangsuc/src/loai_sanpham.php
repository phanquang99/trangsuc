<?php

namespace CT275\Labs;

class loai_sanpham
{
	private $db;

	public $id = -1;
	public $ten_loai;
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
		if (isset($data['name'])) {
			$this->name = trim($data['name']);
		}

		if (isset($data['phone'])) {
			$this->phone = preg_replace('/\D+/', '', $data['phone']);
		}

		if (isset($data['notes'])) {
			$this->notes = trim($data['notes']);
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
		$loai_sanphams = [];
		$stmt = $this->db->prepare('select * from loai_sanpham');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$loai_sanpham = new loai_sanpham($this->db);
			$loai_sanpham->fillFromDB($row);
			$loai_sanphams[] = $loai_sanpham;
		}
		return $loai_sanphams;
	}
	
	protected function fillFromDB(array $row)
	{
		[
			'id_loai' => $this->id,
			'ten_loai' => $this->ten_loai
		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update contacts set name = :name,
phone = :phone, notes = :notes, updated_at = now()
where id = :id');
			$result = $stmt->execute([
				'name' => $this->name,
				'phone' => $this->phone,
				'notes' => $this->notes,
				'id' => $this->id
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into contacts (name, phone, notes, created_at, updated_at)
values (:name, :phone, :notes, now(), now())'
			);
			$result = $stmt->execute([
				'name' => $this->name,
				'phone' => $this->phone,
				'notes' => $this->notes
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();// lay id giao dich cuoi cung
			}
		}
		return $result;
	}
	public function find($id)
	{
		$stmt = $this->db->prepare('select * from loai_sanpham where id = :id');
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
		$stmt = $this->db->prepare('delete from contacts where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
