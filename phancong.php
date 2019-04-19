<?php
    session_start();
    require dirname(__FILE__) . '/class/utils.php';
    require dirname(__FILE__) . '/class/DBController.php';
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

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Offtime Management</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Thống kê</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Công cụ
            </div>

            <!-- Nav Item - Calendar -->
            <li class="nav-item">
                <a class="nav-link" href="calendar.php">
                    <i class="fas fa-fw fa-calendar"></i>
                    <span>Sắp xếp lịch</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="phancong.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Phân công</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="bangphancong.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Bảng phân công</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <? echo $_SESSION['ten']; ?></span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Hồ sơ
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cài đặt
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Thoát
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

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
                                        <div class="col-6">
                                            <div class="row form-group">
                                                <div class="col-3 col-form-label text-right">Giáo Viên: </div>
                                                <div class="col-8 offset-1">
                                                    <select class="form-control form-control-sm" name="GiaoVien" id="">
                                                        <? foreach($listCanBo as $maCB => $canbo): ?>
                                                            <option value="<? echo $maCB?>"><? echo $canbo ?></option>
                                                        <? endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-3 col-form-label text-right">Môn học: </div>
                                                <div class="col-8 offset-1">
                                                    <select class="form-control form-control-sm" name="MonHoc" id="">
                                                        <? foreach($listMonHoc as $maMH => $monhoc): ?>
                                                        <option value="<? echo $maMH?>"><? echo $monhoc ?></option>
                                                        <? endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-3 col-form-label text-right">TG Bắt đầu: </div>
                                                <div class="col-8 offset-1">
                                                    <input type="number" min="0" max="31" name="ngayBatDau" id="ngayBatDau" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-3 col-form-label text-right">TG Kết Thúc: </div>
                                                <div class="col-8 offset-1">
                                                    <input type="number" min="0" max="31" name="ngayKetThuc" id="ngayKetThuc" class="form-control">
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
                                                    <select name="GioHoc" id="GioHoc" class="form-control"
                                                        <option value="G">G</option>
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
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Can Tho University Software Centre 2019</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn thoát?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Chọn "Thoát" để thoát khỏi phiên làm việc.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="logout.php">Thoát</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.js"></script>
</body>

</html>