<?php
include 'config/connection.php';
include 'CanBo.php';
include 'NghiBu.php';
include 'Tuan.php';
Class DBController{
    //Phương thức tạo đối tượng trong cơ sở dữ liệu thông qua câu lệnh DBController::create()
    /**
     * Tạo 1 đối tượng
     * VD: 
     * $obj = new CanBo("cb002", "exam","exam", md5("exam"),"2");
     * DBController::create($obj);
     */
    static function create($obj){
        $conn = DBConnect::getInstance();
        if($conn->query($obj->create()) === TRUE){
            header("Location: calendar.php");
        } else {
            echo "<script>alert('Có lỗi xảy ra');</script>";
        }
    }

    static function update($obj){
        $conn = DBConnect::getInstance();
        if($conn->query($obj->update()) === TRUE){
            header("Location: calendar.php");
        } else {
            echo "<script>alert('Có lỗi xảy ra')</script>";
        }
    }
    
    static function customQuery($sql){
        return DBConnect::getInstance()->query($sql);
    }

}