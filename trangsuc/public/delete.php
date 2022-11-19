<?php
require_once '../bootstrap.php';

use CT275\Labs\sanpham;

$sanpham = new sanpham($PDO);
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['id'])
    && ($sanpham->find($_POST['id'])) !== null
) {
    $sanpham->delete();
}
redirect('nhanvien.php');
