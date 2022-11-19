<?php

if (!is_administrator()) {
    echo '<div style="height: 100px;"></div>';
	echo '<h2 class="text-center text-danger mt-5">Truy cập bị từ chối!</h2>';
	$error_message = 'Bạn không có quyền truy xuất trang này';
	include 'show_error.php';
    echo '<div style="height: 100px;"></div>';
	include 'footer.php';
	exit();
}
