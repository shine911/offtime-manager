<?php
Class Tuan{
    private $ID;
    private $Tuan;
    private $Ngay;
    private $Thang;
    private $Nam;

    function __construct($ID, $Tuan, $Ngay, $Thang, $Nam)
    {
        $this->ID = $ID;
        $this->Tuan = $Tuan;
        $this->Ngay = $Ngay;
        $this->Thang = $Thang;
        $this->Nam = $Nam;
    }

    function create(){
        $sql = "INSERT INTO tuan VALUES('$this->ID', '$this->Tuan', '$this->Ngay', '$this->Thang', '$this->Nam')";
        return $sql;
    }

    /**
     * Get the value of ID
     */ 
    public function getID()
    {
        return $this->ID;
    }

    /**
     * Set the value of ID
     *
     * @return  self
     */ 
    public function setID($ID)
    {
        $this->ID = $ID;

        return $this;
    }

    /**
     * Get the value of Tuan
     */ 
    public function getTuan()
    {
        return $this->Tuan;
    }

    /**
     * Set the value of Tuan
     *
     * @return  self
     */ 
    public function setTuan($Tuan)
    {
        $this->Tuan = $Tuan;

        return $this;
    }

    /**
     * Get the value of Thang
     */ 
    public function getThang()
    {
        return $this->Thang;
    }

    /**
     * Set the value of Thang
     *
     * @return  self
     */ 
    public function setThang($Thang)
    {
        $this->Thang = $Thang;

        return $this;
    }

    /**
     * Get the value of Nam
     */ 
    public function getNam()
    {
        return $this->Nam;
    }

    /**
     * Set the value of Nam
     *
     * @return  self
     */ 
    public function setNam($Nam)
    {
        $this->Nam = $Nam;

        return $this;
    }

    /**
     * Get the value of Ngay
     */ 
    public function getNgay()
    {
        return $this->Ngay;
    }

    /**
     * Set the value of Ngay
     *
     * @return  self
     */ 
    public function setNgay($Ngay)
    {
        $this->Ngay = $Ngay;

        return $this;
    }
}