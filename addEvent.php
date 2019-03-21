<?php
require dirname(__FILE__) . '/class/utils.php';
require dirname(__FILE__) . '/class/DBController.php';

session_start();
if(isset($_GET['btnSubmit'])){
    
    $ma = $_SESSION['taikhoan'];
    if(isset($ma)){
        $tu = $_GET['timebatdau'];
        $den = $_GET['timeketthuc'];
        $lido = $_GET['lido'];
        $lop = $_GET['lop'];
        $ngay = new DateTime($_GET['ngay']);
        $week = $ngay->format('W');
        $sogio = $_GET['sogio'];
        $obj = new NghiBu($ma, $lop, $tu, $den, $lido, $sogio, $ngay->format('Y').$week);
    } else {
        echo "Bạn không có quyền truy cập trang này!";
    }
}

