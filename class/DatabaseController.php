<?php
include 'config/connection.php';
include 'CanBo.php';
Class DatabaseController{
    static function create($obj){
        $conn = DBConnect::getInstance();
        if($conn->query($obj->create()) === TRUE){
            echo 'Them thanh cong';
        }
        echo "done";
    }
    
    static function customQuery($sql){
        return DBConnect::getInstance()->query($sql);
    }

}