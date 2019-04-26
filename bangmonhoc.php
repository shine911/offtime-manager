<?php
    session_start();
    require dirname(__FILE__) . '/class/utils.php';
    require dirname(__FILE__) . '/class/DBController.php';

    if(isset($_SESSION['taikhoan'])){
        if($_SESSION['taikhoan']!='AD001'){
            header('Location: index.php');
        }
    }

    if(isset($_GET['del']) && $_GET['del']!=''){
        $sql = "DELETE FROM monhoc WHERE maMH = ?";
        $conn = DBConnect::getInstance();
        $prepare = $conn->prepare($sql);
        $prepare->bind_param('s', $_GET['del']);
        $prepare->execute();
    }
    $sql = "SELECT mh.maMH, mh.tenMH, mh.soTiet, ct.tenCT, lh.tenLH  from chuongtrinh AS ct, monhoc AS mh, LoaiHinh AS lh WHERE ct.maCT = mh.maCT AND lh.maLH = ct.maLH";

    $result = DBController::customQuery($sql);
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
    <!-- Sidebar and Topbar -->
    <? include 'layout/sidebar.php'; ?>
    <!-- Sidebar and Topbar End -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Thông tin môn học</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Bảng môn học</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Mã Môn</th>
                                            <th>Tên</th>
                                            <th>Chương trình</th>
                                            <th>Loại hình</th>
                                            <th>Số tiết</th>
                                            <th>Công cụ</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Mã Môn</th>
                                            <th>Tên</th>
                                            <th>Chương trình</th>
                                            <th>Loại hình</th>
                                            <th>Số tiết</th>
                                            <th>Công cụ</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <? while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><? echo $row["maMH"] ?></td>
                                            <td><? echo $row["tenMH"] ?></td>
                                            <td><? echo $row["tenCT"]?></td>
                                            <td><? echo $row["tenLH"]?></td>
                                            <td><? echo $row["soTiet"]?></</td>
                                            <td><a href="?del=<? echo $row["maMH"]; ?>" onclick="return confirm('Xóa môn học?')"><i class="fas fa-trash"></i></a></td>
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
        <? include 'layout/footer.php' ?>
        <!-- End Footer -->

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
                { type: "text", targets: 1 },
                { targets: 5, orderable: false}
            ]
        });

        });
    </script>
</body>

</html>