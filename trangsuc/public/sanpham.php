<?php
require_once '../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect

use CT275\Labs\loai_sanpham;
use CT275\Labs\sanpham;

$sanpham = new sanpham($PDO); // khoi tao de sd cac ham
$loai_sanpham = new loai_sanpham($PDO);
$sanphams = $sanpham->all();
$loai_sanphams = $loai_sanpham->all();
include '../partials/header.php';
use CT275\Labs\user;
use CT275\Labs\chitiet_hoadon;
use CT275\Labs\hoadon;
$themvaogioihang=false;
if (is_administrator()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST['tong_giatri'] = ($_POST['soluong'] * $_POST['gia_sp']);
        $_POST['id_user'] = $_SESSION['id_user']; //
        $hoadon = new hoadon($PDO);
        $chitet_hoadon = new chitiet_hoadon($PDO);
        if (!isset($_SESSION['id_hd'])) {
            $hoadon->fill($_POST);
            $hoadon->save_hd();
            $_POST['id_hd'] = $hoadon->getId();
            $_SESSION['id_hd'] = $hoadon->getId();
            $chitet_hoadon->fill($_POST);
            $chitet_hoadon->add_sp();
        } else {
            $chitet_hoadon_fromdbs = $chitet_hoadon->find_id_hd($_SESSION);
            foreach ($chitet_hoadon_fromdbs as $chitet_hoadon_fromdb) {
                if ($chitet_hoadon_fromdb->id_sp == $_POST['id_sp']) {
                    $chitet_hoadon->find_id_hd($_SESSION['id_hd']);
                    $_POST['soluong'] = $_POST['soluong']+ $chitiet_hoadon->soluong;
                    $chitet_hoadon->update_sp($_POST);
                }
            }
        }

    $themvaogioihang=true;
    }
} else{
   
    echo("ban phai dang nhap moi co the");
}

?>

    <main class="container">
        <section class="nav--product row ">
            <div class=" col-7">
                <h5><a class="text-black" href="">Trang chủ</a> / <a class="text-black" href="">Tất cả sản phẩm</a></h5>
            </div>
            <div class="col-2 text-end">
                <p>
                    Hiển thị 19 kết quả</p>
            </div>
            <div class="col-3 text-end">
                <label class="visually-hidden" for="specificSizeSelect">Sắp xếp theo mặc định</label>
                <select class="form-select" id="specificSizeSelect">
                    <option selected>Sắp xếp theo mặc định</option>
                    <option value="1">Sắp xếp theo mặc định 1</option>
                    <option value="2">Sắp xếp theo mặc định 2</option>
                    <option value="3">Sắp xếp theo mặc định 3</option>
                </select>
            </div>
        </section>

        <section>
            <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-4 my-4">
                <?php foreach ($sanphams as $sanpham) : ?>
                    <div class="col my-2">
                        <?php if ($sanpham->gioitinh_sanpham == 1) {
                            $gt = 'nam';
                        } else {
                            $gt = 'nu';
                        }  ?>
                        <img style="width: 100%;" src="images/sanpham/<?= $gt . '/' . $sanpham->hinhanh ?>" alt="err" srcset="">

                        <div class="row ">
                            <div class="col-8">
                                <h6><?= $sanpham->ten ?> </h6>
                            </div>
                            <div class="col-4">
                                <h6 class="mr-0 text-end"> <?= $sanpham->gia . '.vnđ' ?></h6>
                                
                            </div>
                        </div>
                            <form action="" method="POST" class="row delete">
                           <div class="col-8">
                           <input hidden type="text" value="<?= $sanpham->gia ?>" name="gia_sp">
                            <input hidden type="text" value="<?= $sanpham->getId() ?>" name="id_sp">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$sanpham->getId()?>">
                                    Thêm vào giỏ hàng
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?=$sanpham->getId()?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5 " id="exampleModalLabel">Giỏ hàng cho biết</h1>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-start">Bạn đã thêm <?= $_POST['soluong'] ?> sản phẩm vào giỏ hàng!</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="sumbit" class="btn btn-secondary" data-bs-dismiss="modal">Oke</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-end fs-5"><input name="soluong" type="number" value="0" min="0" max="20"></div>
                           </form>
                       

                           
                    </div>
                <?php endforeach ?>
            </div>
        </section>
    </main>
    <?php include('../partials/footer.php') ?>