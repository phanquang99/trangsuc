<?php

require_once '../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect
use CT275\Labs\sanpham;
use CT275\Labs\loai_sanpham;

$sanpham = new sanpham($PDO);
$loai_sanpham = new loai_sanpham($PDO);
$loai_sanphams = $loai_sanpham->all();

$id = isset($_REQUEST['id']) ?
	filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT) : -1;
$sanpham->find($id);
//$loai_sanpham ->find($id);
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($sanpham->update($_POST, $_FILES)) {
		// Cập nhật dữ liệu thành công
		redirect('nhanvien.php');
	}
	// Cập nhật dữ liệu không thành công
	$errors = $sanpham->getValidationErrors();
}
include '../partials/header.php';
?>
<main class="container">
	<section class="nav--product row ">
		<div class=" col-7">
			<h5><a class="text-black" href="">Trang chủ</a> / <a class="text-black" href="">Thêm sản phẩm</a> </h5>
		</div>
	</section>
	<section class="row">
		<div class="col-3"></div>

		<form name="frm" id="frm" action="" method="post" class="col-md-6 col-md-offset-3 was-validated" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?= htmlspecialchars($sanpham->getId()) ?>">
			<input type="hidden" name="ten_loai" value="<?= htmlspecialchars($sanpham->ten_loai) ?>">
			<input type="hidden" name="ten_nv" value="<?= htmlspecialchars($sanpham->ten_nv) ?>">
			<!-- Name -->

			<div class="form-group">
				<label for="ten">Tên sản phẩm</label>
				<input type="text" name="ten" class="form-control is-invalid" maxlen="255" id="name" placeholder="Enter Name" value="<?= htmlspecialchars($sanpham->ten) ?>" required>

				<?php if (isset($errors['ten'])) : ?>
					<div class="invalid-feedback">
						<?= htmlspecialchars($errors['ten']) ?>
					</div>
				<?php endif ?>
			</div>
			<!-- Phone -->
			<div class="form-group">
				<label for="gia">Giá sẩn phẩm</label>
				<input type="text" name="gia" class="form-control is-invalid" maxlen="255" id="phone" placeholder="Enter Phone" value="<?= htmlspecialchars($sanpham->gia)  ?>" required>

				<?php if (isset($errors['gia'])) : ?>
					<div class="invalid-feedback">
						<strong><?= htmlspecialchars($errors['gia']) ?></strong>
					</div>
				<?php endif ?>
			</div>
			<div class="form-group">
				<label for="ten">Hình ảnh</label>
				<input type="file" name="hinhanh" class="form-control is-invalid" maxlen="255" id="name" placeholder="Enter Name" value="<?= htmlspecialchars($sanpham->hinhanh)  ?>" required>
				<?php if (isset($errors['hinhanh'])) : ?>
					<div class="invalid-feedback">
						<strong><?= htmlspecialchars($errors['hinhanh']) ?></strong>
					</div>
				<?php endif ?>
			</div>
			<div class="form-group">
				<label for="gioitinh_sanpham">Giới tính sản phẩm</label>
				<select name="gioitinh_sanpham" class="form-control">
					<option value=" <?= htmlspecialchars($sanpham->gioitinh_sanpham)  ?> ">
						<?php if ($sanpham->gioitinh_sanpham == 1) {
							echo ("Nam");
						} else {
							echo ("Nữ");
						}
						?>
					</option>
					<?php if ($sanpham->gioitinh_sanpham == 1) : ?>
						<option value="0"> Nữ</option>
					<?php endif ?>
					<?php if ($sanpham->gioitinh_sanpham == 0) : ?>
						<option value="1"> Nam</option>
					<?php endif ?>
				</select>
			</div>

			<div class="form-group">
				<label for="loai_sanpham">Loại sản phẩm</label>

				<select name="id_loai" class="form-control">
					<option value=" <?= $sanpham->id_loai ?>"> <?= $sanpham->ten_loai ?></option>
					<?php foreach ($loai_sanphams as $loai_sanpham) : ?>
						<?php if ($sanpham->id_loai != $loai_sanpham->id) : ?>
							<option value=" <?= $loai_sanpham->id ?>"> <?= $loai_sanpham->ten_loai ?></option>
						<?php endif ?>
					<?php endforeach ?>
				</select>
			</div>

			<div class="form-group">
				

				<input hidden type="text" name="id_nv" class="form-control is-invalid" maxlen="255" id="name" placeholder="Enter Name" value=" <?= htmlspecialchars($sanpham->id_nv) ?>" required>
			</div>
			<div class="form-group">
				<label for="soluong">Số lượng</label>
				<input type="text" name="soluong" class="form-control is-invalid" maxlen="255" id="phone" placeholder="Enter Phone" value="<?= htmlspecialchars($sanpham->soluong)  ?>" required>

				<?php if (isset($errors['soluong'])) : ?>
					<div class="invalid-feedback">
						<strong><?= htmlspecialchars($errors['soluong']) ?></strong>
					</div>
				<?php endif ?>
			</div>

			<!-- Submit -->
			<br>
			<button type="submit" name="submit" id="submit" class="btn btn-primary">Lưu sản phẩm</button>
		</form>
	</section>
</main>
<?php include('../partials/footer.php') ?>