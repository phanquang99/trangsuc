<?php

namespace CT275\Labs;

class hoadon
{
	private $db;
	private $id = -1;
	public $id_user;
	public $ngaylap;
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
		if (isset($data['id_user'])) {
			$this->id_user = trim($data['id_user']);
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
		$hoadons = [];
		$stmt = $this->db->prepare('select * from hoadon');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$hoadon = new hoadon($this->db);
			$hoadon->fillFromDB($row);
			$hoadons[] = $hoadon;
		}
		return $hoadons;
	}
	protected function fillFromDB(array $row)
	{
		[
			'id' => $this->id,
			'id_user' => $this->id_user,
			'ngaylap' => $this->ngaylap,
		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update hoadon set id_user = :id_user,
ngaylap = now()
where id = :id');
			$result = $stmt->execute([
				'id_user' => $this->id_user,
				'id' => $this->id
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into hoadon (id_user, ngaylap)
values (:id_user, now())'
			);
			$result = $stmt->execute([
				'id_user' => $this->id_user
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId(); // lay id giao dich cuoi cung va gan cho doi tuong
			}
		}
		return $result;
	}
	public function save_hd()
	{
		$result = false;
		$stmt = $this->db->prepare(
			'insert into hoadon (id_user, ngaylap)
values (:id_user, now())'
		);
		$result = $stmt->execute([
			'id_user' => $this->id_user
		]);
		if ($result) {
			$this->id = $this->db->lastInsertId(); // lay id giao dich cuoi cung va gan cho doi tuong
		}

		return $result;
	}
	public function find($id)
	{
		$stmt = $this->db->prepare('select * from hoadon where id = :id');
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
		$stmt = $this->db->prepare('delete from hoadon where id = :id');
		return $stmt->execute(['id' => $this->id]);
	}
}
