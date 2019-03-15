<?php
/**
 * Lớp cán bộ chứa các phương thức và thuộc tính để thao tác với lớp cán bộ
 */
Class CanBo{
    private $maCB;
    private $tenCB;
    private $taikhoan;
    private $matkhau;
    private $gioChuan;

    function __construct($maCB, $tenCB, $taikhoan, $matkhau, $gioChuan){
        $this->maCB = $maCB;
        $this->tenCB = $tenCB;
        $this->taikhoan = $taikhoan;
        $this->matkhau = $matkhau;
        $this->gioChuan = $gioChuan;
    }
    /**
     * Các phương thức get - set
     */

    function getTenCB(){
        return $this->tenCB;
    }

    function setTenCB($tenCB){
        $this->tenCB = $tenCB;
    }

    function getGioChuan(){
        return $this->gioChuan;
    }

    function setGioChuan($gioChuan){
        $this->gioChuan = $gioChuan;
    }

    function create(){
        $sql = "INSERT INTO canbo VALUES('$this->maCB', '$this->tenCB', '$this->taikhoan', '$this->matkhau', '$this->gioChuan')";
        return $sql;
    }

}