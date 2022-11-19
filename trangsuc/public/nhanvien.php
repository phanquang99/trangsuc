<?php
require_once '../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect
use CT275\Labs\sanpham;

$sanpham = new sanpham($PDO); // khoi tao de sd cac ham
$order_by = 'ten_loai';
$sanphams = $sanpham->order_by($order_by);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sanphams = $sanpham->order_by($_POST['sap_xep']);
    //redirect('nhanvien.php');
}

include '../partials/header.php';
include '../partials/check_admin.php';
?>
<main class="container">
    <section class="nav--product row ">
        <div class=" col-7">
            <h5><a class="text-black" href="">Trang chủ</a> / <a class="text-black" href="">Nhân viên</a></h5>
        </div>
        <div class="col-2 text-end">
            <p>
                Hiển thị <?php echo 32; ?> kết quả</p>
        </div>
        <div class="col-3 text-end">
            <form action="nhanvien.php" method="post">
                <label class="visually-hidden" for="specificSizeSelect"></label>
                <select name="sap_xep" class="form-select" id="specificSizeSelect">
                    <option value="ten_loai">Sắp xếp theo giá trị mặc dịnh</option>
                    <option value="ten">Sắp xếp theo tên sản phẩm</option>
                    <option type="submit" value="ngaynhap">Sắp xếp theo ngày nhập</option>
                    <option value="gioitinh_sanpham">Sắp xếp theo giới tính sản phẩm </option>
                    <option value="gia">Sắp xếp theo giá tiền sản phẩm</option>
                    <option type="submit" value="soluong">Sắp xếp theo số lượng sản phẩm</option>
                    <option type="submit" value="ten_nv">Sắp xếp theo tên nhân viên</option>
                </select>
                <button class="btn btn-primary" type="submit">Oke</button>
            </form>
        </div>
    </section>

    <section>
        <a href="<?= BASE_URL_PATH . 'add.php' ?>" class="btn btn-primary" style="margin-bottom: 30px;">
            <i class="fa fa-plus"></i> Thêm sản phẩm</a>
        <table id="contacts" class="table table-striped table-responsive table-bordered">
            <thead>
                <tr>
                    <th scope="col">Stt</th>
                    <th scope="col">id</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Ngày nhập</th>
                    <th scope="col">Giới tính sản phẩm</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Tên loại</th>
                    <th scope="col">Tên nhân viên</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($sanphams as $sanpham) : ?>
                    <tr>
                        <th scope="row"><?php echo $i++; ?></th>
                        <td><?= htmlspecialchars($sanpham->getId()) ?></td>
                        <td><?= htmlspecialchars($sanpham->ten) ?></td>
                        <td><?= htmlspecialchars($sanpham->gia) . 'vnđ' ?></td>
                        <?php if ($sanpham->gioitinh_sanpham == 1) {
                            $gt = 'nam';
                        } else {
                            $gt = 'nu';
                        }  ?>
                        <td><img style="width: 100px;" src="images/sanpham/<?= $gt . '/' . $sanpham->hinhanh ?>" alt="err"></td>

                        <td><?= date("d-m-Y", strtotime($sanpham->ngaynhap)) ?></td>
                        <td><?php
                            if ($sanpham->gioitinh_sanpham == 1) {
                                echo ("Nam");
                            } else {
                                echo ("Nữ");
                            }
                            ?></td>
                        <td><?= htmlspecialchars($sanpham->soluong) ?></td>
                        <td><?= htmlspecialchars($sanpham->ten_loai) ?></td>
                        <td><?= htmlspecialchars($sanpham->ten_nv) ?></td>
                        <td>
                            <a href="<?= BASE_URL_PATH . 'edit.php?id=' . $sanpham->getId() ?>" class="btn btn-xs btn-warning">
                                <i alt="Edit" class="fa fa-pencil"> Edit</i></a>
                            <form class="delete" action="<?= BASE_URL_PATH . 'delete.php' ?>" method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $sanpham->getId() ?>">
                                <button type="button" class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $sanpham->getId() ?>">
                                    <i alt="Delete" class="fa fa-trash"> Delete</i></button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal<?= $sanpham->getId() ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Trang sức thông báo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc muốn xóa sản phẩm <span class="h5"><?= htmlspecialchars($sanpham->ten) ?> </span> ?.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
</main>
<?php include('../partials/footer.php') ?>