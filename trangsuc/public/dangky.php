<?php
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
    session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
  }
require_once '../bootstrap.php';

use CT275\Labs\user;


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user = new user($PDO);
	$user->fill($_POST);
	if ($user->validate()) {
		$user->save();
		echo("Bạn đã đăng ký thành công");
		
	}
	$errors = $user->getValidationErrors();
}
?>

