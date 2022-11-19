<?php
//require_once '../bootstrap.php';
include '../partials/header.php'; // tu dong nap lop,khong gian ten,dbconnect
use CT275\Labs\sanpham;
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
                    $chitet_hoadon->update_sp();
                }
            }
        }

    $themvaogioihang=true;
    }
} else{
    $themvaogioihang=true;
    echo("ban phai dang nhap moi co the");
}
//nclude '../partials/header.php';
//include '../partials/check_admin.php';
?>
<main class="container">
    <section class="nav--product row ">
        <div class=" col-7">
            <h5><a class="text-black" href="">Trang chủ</a> / <a class="text-black" href="">Giỏ hàng</a></h5>
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
    <section class="container">
        <div class="row">
            <div class="col-8">
                <div class="row">
                    <div class="col-6">
                        <h6>Sản phẩm</h6>
                    </div>
                    <div class="col-2">
                        <h6>Giá</h6>
                    </div>
                    <div class="col-2">
                        <h6>Số lượng</h6>
                    </div>
                    <div class="col-2">
                        <h6>Tạm tính</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h6>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal0">
                                Xóa
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal0" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hãy cho giỏ hàng biết</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có muốn xóa sản phẩm ra khỏi giỏ hàng
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                                            <button type="button" class="btn btn-primary">Có</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="btn-group">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                    Đồng hồ cơ ODIN - The Grey Phantom
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><img src="images/sanpham/nam/daytruyen1.jpg" alt=""></a></li>
                                </ul>
                            </div>
                        </h6>
                    </div>
                    <div class="col-2">
                        <span class="">799.000đ</span>
                    </div>
                    <div class="col-2">
                        <input class="w-50" type="number" value="02">
                    </div>
                    <div class="col-2">
                        <p>799.000đ</p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <h6><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                Xóa
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Giỏ hàng cho biết</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có muốn xóa sản phẩm ra khỏi giỏ hàng ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                    Đồng hồ cơ ODIN - The Grey Phantom
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><img src="images/sanpham/nam/daytruyen1.jpg" alt=""></a></li>
                                </ul>
                            </div>
                        </h6>
                    </div>
                    <div class="col-2">
                        <span class="">799.000đ</span>
                    </div>
                    <div class="col-2">
                        <input class="w-50" type="number" value="02">
                    </div>
                    <div class="col-2">
                        <p>799.000đ</p>
                    </div>

                </div>


            </div>
            <div class="col-4 border border-end-0 border-bottom-0 border-right border-top-0 border-dark">
                <div class="row">
                    <h6 class="text-center">Chi tiết giỏ hàng</h6>
                </div>
                <div class="row">
                    <div class="col">
                        <h6>Tạm tính:</h6>
                    </div>
                    <div class="col text-end">799.000đ</div>
                </div>
                <div class="row">
                    <div class="col">
                        <h6>Giao hàng:</h6>
                    </div>
                    <div class="col text-end">Giao hàng miễn phí</div>
                </div>
                <div class="row">
                    <div class="col">
                        <h6>Tổng:</h6>
                    </div>
                    <div class="col text-end">799.000đ</div>
                </div>
                <div class="row text-end ">
                    <h6>
                        <!-- Button trigger modal -->
                        <button type="button" class="text-white btn btn-secondary btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                            Thanh toán
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hãy cho giỏ hàng biết</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-start">Bạn có muốn thanh toán tất cả những sản phẩm đã chọn ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                                        <button type="button" class="btn btn-primary">Có</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </h6>
                </div>
            </div>

        </div>

    </section>




</main>
<?php include('../partials/footer.php') ?>