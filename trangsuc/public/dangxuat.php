<?php
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
    session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
  }
require_once '../bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if (isset($_SESSION['user'])) {
	unset($_SESSION['user']);
  $_SESSION['id_user'] =null;
  $_SESSION['id_user'] = null;
  $_SESSION['email'] = null;
  $_SESSION['password'] = null;
    echo '<p>Bạn đã đăng xuất thànhh công.</p>';
    redirect('nhanvien.php');
    exit();
   
}
}
?>