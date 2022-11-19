<?php

namespace CT275\Labs;

class user
{
	private $db;

	public $id = -1;
	public $email;
    public $password;
    public $vaitro = 1;
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
		if (isset($data['email'])) {
			$this->email = trim($data['email']);
		}

		if (isset($data['password'])) {
			$this->password = trim($data['password']);
		}

		if (isset($data['vaitro'])) {
			$this->vaitro = trim($data['vaitro']);
		}

		return $this;
	}

	public function getValidationErrors()
	{
		return $this->errors;
	}

	public function validate()
	{
		if (!$this->email) {
			$this->errors['email'] = 'Email không được rỗng.';
		}
        if (!$this->password) {
			$this->errors['password'] = 'Mật khẩu không được rỗng.';
		}

		return empty($this->errors);
	}

	public function all()
	{
		$users = [];
		$stmt = $this->db->prepare('select * from user');
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$user = new user($this->db);
			$user->fillFromDB($row);
			$users[] = $user;
		}
		return $users;
	}
	
	protected function fillFromDB(array $row)
	{
		[
			'id_user' => $this->id,
			'email' => $this->email,
            'password' => $this->password,
            'vaitro' => $this->vaitro
		] = $row;
		return $this;
	}

	public function save()
	{
		$result = false;
		if ($this->id >= 0) {
			$stmt = $this->db->prepare('update user set email = :email,
password = :password, vaitro = :vaitro where id = :id');
			$result = $stmt->execute([
				'name' => $this->name,
				'phone' => $this->phone,
				'notes' => $this->notes,
				'id' => $this->id
			]);
		} else {
			$stmt = $this->db->prepare(
				'insert into user (email, password, vaitro) values (:email, :password, :vaitro)'
			);
			$result = $stmt->execute([
				'email' => $this->email,
				'password' => $this->password,
				'vaitro' => $this->vaitro
			]);
			if ($result) {
				$this->id = $this->db->lastInsertId();// lay id giao dich cuoi cung
			}
		}
		return $result;
	}
	public function find($id)
	{
		$stmt = $this->db->prepare('select * from user where id = :id');
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
