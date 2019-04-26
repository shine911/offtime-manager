<?php
    session_start();
    require dirname(__FILE__) . '/class/utils.php';
    require dirname(__FILE__) . '/class/DBController.php';
    if(isset($_SESSION['taikhoan'])){
        if($_SESSION['taikhoan']!='AD001'){
            header('Location: index.php');
        }
    }
    if(isset($_POST['btnSubmit'])){
        //Lazy make another class
        $conn = DBConnect::getInstance();
        $maCB = $_POST['GiaoVien'];
        $monHoc = $_POST['MonHoc'];
        $ngayBatDau = $_POST['ngayBatDau'];
        $ngayKetThuc = $_POST['ngayKetThuc'];
        $thang = $_POST['thang'];
        $giohoc = $_POST['GioHoc'];
        $soTiet = $_POST['soTiet'];
        //End of need
        $get = DBController::customQuery("SELECT TGBatDau, TGKetThuc FROM phancong WHERE Thang = '$thang' AND Gio = '$giohoc'");
        $flags = true;
        
        while($result = $get->fetch_assoc()){
            if($ngayBatDau >= $result['TGBatDau'] && $ngayBatDau <= $result['TGKetThuc']){
                $flags = false;
                break;
            }
        }

        if($flags){
            $prepare = $conn->prepare("INSERT INTO phancong VALUES(?, ?, ?, ?, ?, ?, ?)");
            $prepare->bind_param("ssiissi", $maCB, $monHoc, $ngayBatDau, $ngayKetThuc, $thang, $giohoc, $soTiet);
            $prepare->execute();
            echo "<script>alert('Thêm thành công !');</script>";

        } else {
            echo "<script>alert('Thời gian bị trùng xin vui lòng thử lại');</script>";
        }
        
    }

    $listCanBo = array();
    $listMonHoc = array();
    $sql = "SELECT MaCB ,TenCB FROM canbo";
    $result = DBController::customQuery($sql);
    while($row = $result->fetch_assoc()){
        $listCanBo[$row['MaCB']] = $row['TenCB'];
    }
    $sql = "SELECT maMH, tenMH FROM monhoc";
    $result = DBController::customQuery($sql);
    while($row = $result->fetch_assoc()){
        $listMonHoc[$row['maMH']] = $row['tenMH'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CUSC Offtime Management</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <!-- Sidebar and Topbar -->
    <? include 'layout/sidebar.php'; ?>
    <!-- Sidebar and Topbar End -->

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        Phân công
                    </div>
                    <div class="card-body">
                        <form method="post" class="row">
                            <div class="col-6">
                                <div class="row form-group">
                                    <div class="col-3 col-form-label text-right">Giáo Viên: </div>
                                    <div class="col-8 offset-1">
                                        <select class="form-control form-control-sm" name="GiaoVien" id="">
                                            <? foreach($listCanBo as $maCB => $canbo): ?>
                                            <option value="<? echo $maCB?>">
                                                <? echo $canbo ?>
                                            </option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-3 col-form-label text-right">Môn học: </div>
                                    <div class="col-8 offset-1">
                                        <select class="form-control form-control-sm" name="MonHoc" id="">
                                            <? foreach($listMonHoc as $maMH => $monhoc): ?>
                                            <option value="<? echo $maMH?>">
                                                <? echo $monhoc ?>
                                            </option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-3 col-form-label text-right">TG Bắt đầu: </div>
                                    <div class="col-8 offset-1">
                                        <input type="number" min="0" max="31" name="ngayBatDau" id="ngayBatDau"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-3 col-form-label text-right">TG Kết Thúc: </div>
                                    <div class="col-8 offset-1">
                                        <input type="number" min="0" max="31" name="ngayKetThuc" id="ngayKetThuc"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row form-group">
                                    <div class="col-3 col-form-label text-right">Tháng:</div>
                                    <div class="offset-1 col-8">
                                        <input class="form-control" type="month" name="thang" id="thang">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-3 col-form-label text-right">Giờ:</div>
                                    <div class="offset-1 col-8">
                                        <select name="GioHoc" id="GioHoc" class="form-control" <option value="G">G
                                            </option>
                                            <option value="H">H</option>
                                            <option value="J">J</option>
                                            <option value="K">K</option>
                                            <option value="F">F</option>
                                            <option value="M">M</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-3 col-form-label text-right">Số Tiết:</div>
                                    <div class="offset-1 col-8">
                                        <input class="form-control" type="text" name="soTiet" id="soTiet">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-right">
                                <hr>
                                <button type="submit" name="btnSubmit" title="Lưu thông tin" class="btn btn-primary"><i
                                        class="fas fa-save"></i></button>
                                <button type="reset" title="Làm lại" class="btn btn-danger"><i
                                        class="fas fa-trash"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

<!-- Footer -->
<? include 'layout/footer.php' ?>
        <!-- End Footer -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.js"></script>
</body>

</html>