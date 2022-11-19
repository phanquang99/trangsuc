<?php
require_once '../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect

use CT275\Labs\loai_sanpham;
use CT275\Labs\sanpham;

$sanpham = new sanpham($PDO); // khoi tao de sd cac ham
$loai_sanpham = new loai_sanpham($PDO);
$sanphams = $sanpham->all();
$loai_sanphams = $loai_sanpham->all();

include '../partials/header.php';
?>


<main>
  <section>
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="6000">
          <img src="images/trangchu/women1.jpeg" height="550px" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>First slide label</h5>
            <p>Some representative placeholder content for the first slide.</p>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="5000">
          <img src="images/trangchu/nam.avif" height="550px" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Second slide label</h5>
            <p>Some representative placeholder content for the second slide.</p>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="2000">
          <img src="images/women1.jpeg" height="550px" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Third slide label</h5>
            <p>Some representative placeholder content for the third slide.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
  <section class="mt-4">
    <div class="row">
      <?php foreach ($loai_sanphams as $loai_sanpham) : ?>

        <div class="col">
          <div id="carouselExample<?= $loai_sanpham->getId() ?>" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-inner">

              <?php foreach ($sanphams as $sanpham) : ?>
                <?php if (($loai_sanpham->getId() == $sanpham->id_loai) && ($sanpham->gioitinh_sanpham == 1)) : ?>
                  <div class="carousel-item active" data-bs-interval="2500">
                    <img src="images/sanpham/nam/<?= $sanpham->hinhanh ?>" class="d-block w-100" alt="err">
                    <div class="carousel-caption d-none d-md-block">
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <a href="sanpham.php" class="text-black"><h5 class="">Xem</h5></a>
                  </button>
                    </div>
                  </div>
                <?php endif ?>
              <?php endforeach ?>
            </div>

          </div>
          <h5 class="text-white bg-black text-center mb-0"><?= $loai_sanpham->ten_loai . ' Nam' ?></h5>
        </div>

      <?php endforeach ?>
    </div>

  </section>
  <section class="mt-4">
    <div class="row">
      <?php foreach ($loai_sanphams as $loai_sanpham) : ?>

        <div class="col">
          <div id="carouselExample<?= $loai_sanpham->getId() ?>" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-inner">

              <?php foreach ($sanphams as $sanpham) : ?>
                <?php if (($loai_sanpham->getId() == $sanpham->id_loai) && ($sanpham->gioitinh_sanpham == 0)) : ?>
                  <div class="carousel-item active" data-bs-interval="2500">
                    <img src="images/sanpham/nu/<?= $sanpham->hinhanh ?>" class="d-block w-100" alt="err">
                    <div class="carousel-caption d-none d-md-block">
                    </div>
                  </div>
                <?php endif ?>
              <?php endforeach ?>
            </div>

          </div>
          <h5 class="text-white bg-black text-center mb-0"><?= $loai_sanpham->ten_loai . ' Nữ' ?></h5>
        </div>

      <?php endforeach ?>
    </div>

  </section>

</main>
<?php include('../partials/footer.php') ?>