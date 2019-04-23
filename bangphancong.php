<?php
    session_start();
    require dirname(__FILE__) . '/class/utils.php';
    require dirname(__FILE__) . '/class/DBController.php';
    if(isset($_GET['thang'])){
        $thang = $_GET['thang'];
        $sql = "SELECT cb.TenCB, mh.tenMH, pc.TGBatDau, pc.TGKetThuc, pc.Thang, pc.Gio, pc.SoTiet from phancong AS pc, monhoc AS mh, canbo AS cb WHERE pc.MaCB = cb.MaCB AND pc.maMH = mh.maMH AND Thang = '$thang'";
    } else {
        $sql = "SELECT cb.TenCB, mh.tenMH, pc.TGBatDau, pc.TGKetThuc, pc.Thang, pc.Gio, pc.SoTiet from phancong AS pc, monhoc AS mh, canbo AS cb WHERE pc.MaCB = cb.MaCB AND pc.maMH = mh.maMH";
    }
    $listCanBo = array();
    $listMonHoc = array();
    $result = DBController::customQuery($sql);
    if($result->num_rows == 0){
        header('Location: bangphancong.php');
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
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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

            <li class="nav-item">
                <a class="nav-link" href="phancong.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Phân công</span></a>
            </li>

            <li class="nav-item active">
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
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Thông tin bảng phân công</h1>
                    <form class="form-inline mb-4" action="" method="get">
                        <div class="form-group mb-2">
                            <label for="label" class="sr-only">Tháng</label>
                            <input type="text" readonly class="form-control-plaintext" id="label" value="Tháng">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="inputMonth" class="sr-only">Password</label>
                            <input type="month" name="thang" class="form-control" id="inputMonth" value="<? echo isset($_GET['thang'])?$_GET['thang']:date('Y-m') ?>">
                        </div>
                        <button id="confirm" type="submit" title="Xác nhận" class="btn btn-primary mb-2"><i class="fas fa-check fa-sm fa-fw"></i></button>
                        <button id="print" type="button" title="Xuất file" class="btn btn-info ml-2 mb-2"><i class="fas fa-file-excel fa-sm fa-fw"></i></button>
                    </form>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Bảng phân công</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tên CB</th>
                                            <th>Môn học</th>
                                            <th>Từ ngày</th>
                                            <th>Đến ngày</th>
                                            <th>Tháng</th>
                                            <th>Số tiết</th>
                                            <th>Giờ</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Tên CB</th>
                                            <th>Môn học</th>
                                            <th>Từ ngày</th>
                                            <th>Đến ngày</th>
                                            <th>Tháng</th>
                                            <th>Số tiết</th>
                                            <th>Giờ</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <? while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><? echo $row["TenCB"] ?></td>
                                            <td><? echo $row["tenMH"] ?></td>
                                            <td><? echo $row["TGBatDau"]?></td>
                                            <td><? echo $row["TGKetThuc"]?></td>
                                            <td><? echo $row["Thang"]?></td>
                                            <td><? echo $row["Gio"]?></td>
                                            <td><? echo $row["SoTiet"]?></td>
                                        </tr>
                                        <? endwhile ?>
                                    </tbody>
                                </table>
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
    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
    // Call the dataTables jQuery plugin
        $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Vietnamese.json"
        },
        "columnDefs": [
                { type: "phoneNumber", targets: 0 }
            ]
        });

        $('#print').click(function(){
            var thang = $('#inputMonth').val();
            window.location.href = 'export.php?thang='+thang;
        });
        });
    </script>
</body>

</html>