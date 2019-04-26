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
        $maMH = $_POST['txtMaMH'];
        $tenMH = $_POST['txtTenMH'];
        $soTiet = $_POST['soTiet'];
        $conn = DBConnect::getInstance();
        $sql = "INSERT INTO monhoc VALUES(?, ?, ?)";

        //Phân loại
        if(isset($_POST['sltCT'])){
            $maCT = $_POST['sltCT'];
        } else {
            $maCT = $_POST['txtMaCT'];
            $tenCT = $_POST['txtTenCT'];
            $maLH = $_POST['sltLH'];
            $_tempsql = "INSERT INTO chuongtrinh VALUES(?, ? , ?)";
            $prepare = $conn->prepare($_tempsql);
            $prepare->bind_param('sss', $maCT, $tenCT, $maLH);
        }
        $prepare = $conn->prepare($sql);
        $prepare->bind_param('ssss', $maMH, $tenMH, $soTiet, $maCT);
        $prepare->execute();
        echo "done!";
    }

    $sql = "SELECT maCT, tenCT FROM chuongtrinh";
    $result = DBController::customQuery($sql);
    while($row = $result->fetch_assoc()){
        $listChuongTrinh[$row['maCT']] = $row['tenCT'];
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
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    Phân công
                                </div>
                                <div class="card-body">
                                    <form method="post" class="row">
                                        <div class="col-8">
                                            <div class="row form-group">
                                                <div class="col-3 col-form-label text-right">Mã môn học: </div>
                                                <div class="col-8 offset-1">
                                                    <input type="text" name="txtMaMH" id="maMH" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-3 col-form-label text-right">Tên Môn học: </div>
                                                <div class="col-8 offset-1">
                                                    <input type="text" name="txtTenMH" id="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-3 col-form-label text-right">Chương Trình</div>
                                                <div class="col-8 offset-1">
                                                    <select name="sltCT" id="sltCT">
                                                        <? foreach($listChuongTrinh as $maCT => $chuongtrinh): ?>
                                                        <option value="<? echo $maCT?>">
                                                            <? echo $chuongtrinh ?>
                                                        </option>
                                                        <? endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-3 form-check-label text-right">Tạo chương trình mới:</div>
                                                <div class="col-8 offset-1">
                                                    <input type="checkbox" name="chkBox" id="chkBox">
                                                </div>
                                            </div>
                                            <div id="themCT">
                                                <div class="row form-group" >
                                                    <div class="col-3 col-form-label text-right">Mã chương trình: </div>
                                                        <div class="col-8 offset-1">
                                                            <input type="text" name="txtMaCT" id="MaCT" class="form-control">
                                                        </div>
                                                </div>
                                                <div class="row form-group" >
                                                    <div class="col-3 col-form-label text-right">Tên chương trình: </div>
                                                        <div class="col-8 offset-1">
                                                            <input type="text" name="txtTenCT" id="tenCT" class="form-control">
                                                        </div>
                                                </div>
                                                <div class="row form-group">
                                                <div class="col-3 col-form-label text-right">Loại hình</div>
                                                <div class="col-8 offset-1">
                                                    <select name="sltLH" id="sltLH">
                                                        <option value="NH">Ngắn hạn</option>
                                                        <option value="DH">Dài hạn</option>
                                                    </select>
                                                </div>
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
                                            <button type="submit" name="btnSubmit" title="Lưu thông tin" class="btn btn-primary"><i class="fas fa-save"></i></button>
                                            <button type="reset" title="Làm lại" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
    
    <script>
        $(document).ready(function() {
            $("#themCT").hide();
            $("#themCT input").prop('disabled', true);
            $("#themCT select").prop('disabled', true);
            $("#chkBox").change(function(){
                if($(this).prop('checked')){
                    $('#sltCT').prop('disabled', true);
                    $("#themCT").show();
                    $("#themCT input").prop('disabled', false);
                    $("#themCT select").prop('disabled', false);
                } else {
                    $('#sltCT').prop('disabled', false);
                    $("#themCT").hide();
                    $("#themCT input").prop('disabled', true);
                    $("#themCT select").prop('disabled', true);
                }
            });
        });
    </script>
</body>

</html>