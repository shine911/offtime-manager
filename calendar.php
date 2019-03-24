<?php
  session_start();
  require dirname(__FILE__) . '/class/utils.php';
  require dirname(__FILE__) . '/class/DBController.php';
  $taikhoan = $_SESSION["taikhoan"];
  $sql = "SELECT * FROM nghibu WHERE MaCB = '$taikhoan'";
  $result = DBController::customQuery($sql);
  $output_array = array();
  while($row = $result->fetch_assoc()){
    $array = array("title"=> $row['LiDo']." - ".$row['Lop'], "start"=>$row['Tu'], "end"=>$row['Den']);
    $event = new Event($array, new DateTimeZone('Asia/Ho_Chi_Minh'));
    $output_array[] = $event->toArray();
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
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />


  <!-- Fullcalendar IO -->
  <link href='vendor/fullcalendar/packages/core/main.css' rel='stylesheet' />
  <link href='vendor/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
  <link href='vendor/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
  <link href='vendor/fullcalendar/packages/list/main.css' rel='stylesheet' />
  <script src='vendor/fullcalendar/packages/core/main.js'></script>
  <script src='vendor/fullcalendar/packages/interaction/main.js'></script>
  <script src='vendor/fullcalendar/packages/daygrid/main.js'></script>
  <script src='vendor/fullcalendar/packages/timegrid/main.js'></script>
  <script src='vendor/fullcalendar/packages/list/main.js'></script>
  <script src='vendor/fullcalendar/packages/core/locales-all.js'></script>

  <script>

    document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var initialLocaleCode = 'vi';

  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'dayGrid', 'timeGrid', 'list', 'interaction' ],
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    locale: initialLocaleCode,
    dateClick: function(info) {
      $('#popupCalendar').on('show.bs.modal', function (event) {
      var date = info.dateStr;
      var modal = $(this);
      modal.find('.modal-title').text(date);
      modal.find('#ngay').val(date);
      });
      $('#popupCalendar').modal();
    },
    eventClick: function(info){
      $('#popupCalendar').on('show.bs.modal', function (event) {
      var modal = $(this);
      var objEvent = info.event;
      var dStart = new Date(objEvent.start);
      var dEnd = new Date(objEvent.end);
      var title = dStart.toISOString().slice(0, 10) //Tiêu đề trang 2019-xx-xx
      var reason = objEvent.title.split(" - "); //Cắt chuỗi title nhận từ server EX: "Bận - CP1796H03" tách thành Bận, CP1796H03
      modal.find('.modal-title').text(title);
      modal.find('#ngay').val(title);
      modal.find("#time-picker1").val(dStart.toLocaleTimeString('en-GB').slice(0,5));
      modal.find("#time-picker2").val(dEnd.toLocaleTimeString('en-GB').slice(0,5));
      modal.find("#lido").val(reason[0]); //Truyền lý do từ chuỗi đã cắt
      modal.find("#lop").val(reason[1]); //Truyền lớp vào chuỗi đã cắt
      modal.find("#btnSubmit").val("Cập nhật");
      });
      
      $('#popupCalendar').modal();
    },
    navLinks: true, // can click day/week names to navigate views
    editable: true,
    eventLimit: true, // allow "more" link when too many events
    events: <?php echo json_encode($output_array, JSON_UNESCAPED_UNICODE) ?>
  });
  calendar.setOption('locale', 'vi');
  calendar.render();
});
</script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Offtime Management</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Công cụ
      </div>

      <!-- Nav Item - Calendar -->
      <li class="nav-item active">
        <a class="nav-link" href="calendar.php">
          <i class="fas fa-fw fa-calendar"></i>
          <span>Calendar</span></a>
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
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><? echo $_SESSION['ten']; ?></span>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  Lịch nghỉ bù
                </div>
                <div class="card-body">
                  <div id='calendar'></div>
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
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

  <!-- Calendar Modal -->
  <div id="popupCalendar" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cập nhật lịch nghỉ bù</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="addEvent.php" method="get">
          <div class="modal-body">
            <div class="form-group">
              <label for="time-picker1">Từ</label>
              <input type="text" name="timebatdau" class="form-control" id="time-picker1" readonly>
            </div>
            <div class="form-group">
              <label for="time-picker2">Đến</label>
              <input type="text" name="timeketthuc" class="form-control" id="time-picker2" readonly>
            </div>
            <div class="form-group">
              <label for="lydo">Lí Do <supper>(*)</supper>
              </label>
              <input type="text" name="lido" class="form-control" id="lido" placeholder="Có việc bận, bệnh, nghỉ ngơi,..." required>
            </div>
            <div class="form-group">
              <label for="lop">Lớp <supper>(*)</supper>
              </label>
              <input type="text" name="lop" class="form-control" id="lop" placeholder="CP1796H03" required>
            </div>
            <div class="form-group">
              <label for="sogio">Số Giờ <supper>(*)</supper>
              </label>
              <input type="text" name="sogio" class="form-control" id="sogio" placeholder="Thời gian bắt đầu - Thời gian kết thúc" required>
            </div>
            <div class="form-group">
              <label for="ngay">Ngày
              </label>
              <input name="ngay" type="text" class="form-control" id="ngay" readonly>
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary" value="Lưu thông tin">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          </div>
        </form>
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
  
  <!-- Timepicker -->
  <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
  <!-- endTimePicker -->
  <script>
        $('#time-picker1').timepicker({
            uiLibrary: 'bootstrap4'
        });
        $('#time-picker2').timepicker({
            uiLibrary: 'bootstrap4'
        });
  </script>
</body>

</html>