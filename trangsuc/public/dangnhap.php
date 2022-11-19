<?php
if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
    session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}
require_once '../bootstrap.php';

use CT275\Labs\sanpham;
use CT275\Labs\user;

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user1 = new user($PDO);
    $user_formdb = $user1->all();

    $user2 = new user($PDO);
    $user_dangnhap = $user2->fill($_POST);
    foreach ($user_formdb as $user) :
        if (($user->email == $user_dangnhap->email) && $user->password == $user_dangnhap->password ) {
            $_SESSION['user'] = 'me';
            $_SESSION['id_user'] = $user->id;
            $_SESSION['email'] = $user->email;
            $_SESSION['password'] = $user->password;
           // echo ('ban da dang nhap thanh cong');
           if( $user->vaitro==2){
            redirect('nhanvien.php');
           }else{
            redirect('sanpham.php');
           }    
        }
    endforeach;
    echo ("bạn đã đăng nhập thất bại");
}
