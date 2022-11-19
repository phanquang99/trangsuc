<?php
require_once '../bootstrap.php'; // tu dong nap lop,khong gian ten,dbconnect
use CT275\Labs\user;

if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
  session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}
include __DIR__ . '/../functions.php';

?>
<!DOCTYPE html>
<html>

<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <script src="https://kit.fontawesome.com/e3c1c0124c.js" crossorigin="anonymous"></script>

</head>

<body class="">
  <header>
    <nav class="navbar fixed-top navbar-expand-lg">
      <div class="container-fluid position-relative ">
        <a class="navbar-brand " href="index.php"><img class="logo--odin" src="images/logo4.png" alt="" srcset=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="fs-4 navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item position-relative">
              <a class="nav-link text-black" aria-current="page" href="sanpham.php">Tất cả sản phẩm</a>

            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Đàn Ông
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Phụ Nữ
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Best Seller
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li>
          </ul>

          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="mx-2 btn btn-outline-primary" type="submit">Search</button>
          </form>
          <div class="my-2">
            <span>
              <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-regular fa-user"></i>
              </button></span>
            <button type="button" class="btn  position-relative">
              <span><a href="giohang.php"><i class=" text-primary fs-3 fa-solid fa-cart-shopping"></i></a></span>

              <span class="position-absolute top-0 start-105 translate-middle badge rounded-pill bg-danger">
                9
                <span class="visually-hidden">unread messages</span>
              </span>
            </button>


          </div>
        </div>

      </div>

    </nav>

    <!-- dang nhap -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <?php if (!is_administrator()) : ?>
            <div class="modal-body">
              <div class="row g-3">
                <div class="col">
                  <h5 class="modal-title fs-5" id="staticBackdropLabel">Đăng nhập</h5>
                  <form class="delete" action="<?= BASE_URL_PATH . 'dangnhap.php' ?>" method="POST" style="display: inline;">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Email</label>
                      <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                      <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <input name="vaitro" type="text" hidden value="1">
                    <div class="mb-3 form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1">Ghi nhớ mật khẩu</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>

                    <div class="my-3"><a href="">Quên mật khẩu</a></div>
                  </form>
                </div>
                <div class="col">
                  <h5 class="modal-title fs-5" id="staticBackdropLabel1">Đăng ký</h5>
                  <form class="delete" action="<?= BASE_URL_PATH . 'dangky.php' ?>" method="POST" style="display: inline;">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Email</label>
                      <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                      <input type="password" class="form-control" id="exampleInputPassword1">
                    </div>

                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Nhập lại mật khẩu</label>
                      <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endif ?>

          <?php if (is_administrator()) : ?>
            <div class="modal-body">
              <div class="row g-3">
                <div class="col">
                  <h5 class="modal-title fs-5" id="staticBackdropLabel">Đăng xuất</h5>
                  <form  action="<?= BASE_URL_PATH .'dangxuat.php' ?>" method="POST" style="display: inline;">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Email</label>
                      <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= $_SESSION['email']?>">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                      <input name="password" type="password" class="form-control" id="exampleInputPassword1" value="<?= $_SESSION['password']?>">
                    </div>
                    <input name="vaitro" type="text" hidden value="1">
                    <button type="submit" class="btn btn-primary">Đăng xuất</button>

                    <div class="my-3"><a href="">Quên mật khẩu</a></div>
                  </form>

                </div>

              </div>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>





  </header>