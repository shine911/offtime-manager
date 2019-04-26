<?php

	/**
	 * File config/connection.php chứa thông tin connect của mysql
	 */
	include 'class/DBController.php';
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
	
	//Kiểm tra sự tồn tại session tài khoản
	if(isset($_SESSION['taikhoan']))
	{
		header('Location: index.php');
	}

	//Nếu người dùng click nút đăng nhập
	if(isset($_POST['btnSubmit'])){
		$taikhoan = $_POST['taikhoan'];
		$sql = "SELECT MaCB, TenCB, MatKhau FROM canbo WHERE TaiKhoan =  '$taikhoan'";
		$result = DBController::customQuery($sql);
		
		//Kiểm tra số dòng lớn hơn 0 thì tiếp tục
		if($result->num_rows > 0){
			//Lấy dữ liệu của query ra dạng mảng
			$row = $result->fetch_assoc();

			//Kiểm tra mật khẩu đã được mã hóa hay chưa
			if(!isValidMd5($_POST['matkhau'])){
				$matkhau = md5($_POST['matkhau']);
			} else {
				$matkhau = $_POST['matkhau'];
			}
			//Xác nhận mật khẩu
			if($matkhau === $row['MatKhau']){
				//Đặt session
				$_SESSION['taikhoan'] = $row['MaCB'];
        $_SESSION['ten'] = $row['TenCB'];

				//setcookie
				if(isset($_POST['chbox'])){
					setcookie("taikhoan", $taikhoan);
					setcookie("matkhau", $matkhau);
				}
				header('Location: index.php');
			}
		}
		$message = '<div id="error" class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Lỗi!</strong> kiểm tra lại mật khẩu và tài khoản
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
    
	}

	/**
	 * Is vaild md5
	 * https://stackoverflow.com/questions/14300696/check-if-string-is-an-md5-hash
	 */
	function isValidMd5($md5 ='')
	{
		return preg_match('/^[a-f0-9]{32}$/', $md5);
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

  <title>Hệ thống CUSC</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Đăng Nhập Hệ Thống</h1>
                    <? echo isset($message)?$message:''; ?>
                  </div>
                  <form class="user" action="" method="post">
                    <div class="form-group">
                      <input name="taikhoan" type="text" class="form-control form-control-user" id="username" aria-describedby="usernameHelp" placeholder="Nhập tài khoản">
                    </div>
                    <div class="form-group">
                      <input name="matkhau" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Mật Khẩu">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label name="chbox" class="custom-control-label" for="customCheck">Ghi nhớ tài khoản và mật khẩu</label>
                      </div>
                    </div>
                    <input type="submit" name="btnSubmit" value="Đăng nhập" class="btn btn-primary btn-user btn-block">
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
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
  <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>
