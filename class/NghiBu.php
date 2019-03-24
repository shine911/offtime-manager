<?php
Class NghiBu{
    private $MaCB;
    private $Lop;
    private $Tu;
    private $Den;
    private $LiDo;
    private $SoGio;
    private $IDTuan;

    function __construct($MaCB, $Lop, $Tu, $Den, $LiDo, $SoGio, $ngay)
    {
        $this->MaCB = $MaCB;
        $this->Lop = $Lop;
        $this->Tu = $Tu;
        $this->Den = $Den;
        $this->LiDo = $LiDo;
        $this->SoGio = $SoGio;
        $week = $ngay->format('W');
        $this->IDTuan = new Tuan($ngay->format('Ymd'), $week, $ngay->format('d'), $ngay->format('m'), $ngay->format('Y'));
    }

    function create(){
        $id = $this->IDTuan->getID();
        $sql = "INSERT INTO nghibu VALUES('$this->MaCB', '$this->Lop', '$this->Tu', '$this->Den', '$this->LiDo', '$this->SoGio', '$id')";
        return $sql;
    }

    function update(){
        $id = $this->IDTuan->getID();
        $sql = "UPDATE nghibu SET Tu = '$this->Tu', Den = '$this->Den', LiDo = '$this->LiDo' WHERE MaCB = '$this->MaCB' AND IDTuan = '$id'";
        return $sql;
    }
    /**
     * Get the value of MaCB
     */ 
    public function getMaCB()
    {
        return $this->MaCB;
    }

    /**
     * Set the value of MaCB
     *
     * @return  self
     */ 
    public function setMaCB($MaCB)
    {
        $this->MaCB = $MaCB;

        return $this;
    }

    /**
     * Get the value of Lop
     */ 
    public function getLop()
    {
        return $this->Lop;
    }

    /**
     * Set the value of Lop
     *
     * @return  self
     */ 
    public function setLop($Lop)
    {
        $this->Lop = $Lop;

        return $this;
    }

    /**
     * Get the value of Tu
     */ 
    public function getTu()
    {
        return $this->Tu;
    }

    /**
     * Set the value of Tu
     *
     * @return  self
     */ 
    public function setTu($Tu)
    {
        $this->Tu = $Tu;

        return $this;
    }

    /**
     * Get the value of Den
     */ 
    public function getDen()
    {
        return $this->Den;
    }

    /**
     * Set the value of Den
     *
     * @return  self
     */ 
    public function setDen($Den)
    {
        $this->Den = $Den;

        return $this;
    }

    /**
     * Get the value of LiDo
     */ 
    public function getLiDo()
    {
        return $this->LiDo;
    }

    /**
     * Set the value of LiDo
     *
     * @return  self
     */ 
    public function setLiDo($LiDo)
    {
        $this->LiDo = $LiDo;

        return $this;
    }

    /**
     * Get the value of SoGio
     */ 
    public function getSoGio()
    {
        return $this->SoGio;
    }

    /**
     * Set the value of SoGio
     *
     * @return  self
     */ 
    public function setSoGio($SoGio)
    {
        $this->SoGio = $SoGio;

        return $this;
    }

    /**
     * Get the value of IDTuan
     */ 
    public function getIDTuan()
    {
        return $this->IDTuan;
    }

    /**
     * Set the value of IDTuan
     *
     * @return  self
     */ 
    public function setIDTuan($IDTuan)
    {
        $this->IDTuan = $IDTuan;

        return $this;
    }
}