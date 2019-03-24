<?php
require dirname(__FILE__) . '/class/utils.php';
require dirname(__FILE__) . '/class/DBController.php';

session_start();
if(isset($_GET['btnSubmit'])){
    $ma = $_SESSION['taikhoan'];
    if($_GET['btnSubmit'] == "Cập nhật"){
        $ngay = new DateTime($_GET['ngay']);
            $tu =  $ngay->format('Y-m-d').' '.$_GET['timebatdau'].':00';
            $den = $ngay->format('Y-m-d').' '.$_GET['timeketthuc'].':00';
            $lido = $_GET['lido'];
            $lop = $_GET['lop'];
            $sogio = $_GET['sogio'];
            $obj = new NghiBu($ma, $lop, $tu, $den, $lido, $sogio, $ngay);
            DBController::update($obj);
    }else {
        if(isset($ma)){
            $ngay = new DateTime($_GET['ngay']);
            $tu =  $ngay->format('Y-m-d').' '.$_GET['timebatdau'].':00';
            $den = $ngay->format('Y-m-d').' '.$_GET['timeketthuc'].':00';
            $lido = $_GET['lido'];
            $lop = $_GET['lop'];
            $sogio = $_GET['sogio'];
            $obj = new NghiBu($ma, $lop, $tu, $den, $lido, $sogio, $ngay);
    
            DBController::create($obj->getIDTuan());
            DBController::create($obj);
        }
    }
} else {
    echo "Bạn không có quyền truy cập trang này!";
}

