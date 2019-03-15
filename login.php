<?php

	/**
	 * File config/connection.php chứa thông tin connect của mysql
	 */
	include 'config/connection.php';
	session_start();
	
	//Kiểm tra sự tồn tại session tài khoản
	if(isset($_SESSION['taikhoan']))
	{
		header('Location: index.php');
	}

	//Nếu người dùng click nút đăng nhập
	if(isset($_POST['btnSubmit'])){
		$taikhoan = $_POST['taikhoan'];
		$sql = "SELECT MatKhau FROM canbo WHERE TaiKhoan =  '$taikhoan'";
		$result = $conn->query($sql);
		
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
			if($matkhau === $row['MatKhau'] || $_COOKIE['MatKhau']){
				//Đặt session
				$_SESSION['taikhoan'] = $taikhoan;

				//setcookie
				if(isset($_POST['chbox'])){
					setcookie("taikhoan", $taikhoan);
					setcookie("matkhau", $matkhau);
				}
				header('Location: index.php');
			}
		}
		echo "<script>alert('Mật khẩu và tài khoản sai vui lòng thử lại!')</script>";
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
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="assets/css/now-ui-login.css">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Đăng nhập</h3>
			</div>
			<div class="card-body">
				<form action="" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input name="taikhoan" type="text" class="form-control" placeholder="Tài khoản" value="<? if(isset($_COOKIE['taikhoan'])) echo $_COOKIE['taikhoan'] ?>">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input name="matkhau" type="password" class="form-control" placeholder="Mật Khẩu" value="<? if(isset($_COOKIE['matkhau'])) echo $_COOKIE['matkhau'] ?>">
					</div>
					<div class="row align-items-center remember">
						<input name="chbox" type="checkbox" <? if(isset($_COOKIE['taikhoan'])) echo 'checked' ?> value="on"> Ghi nhớ tài khoản và mật khẩu
					</div>
					<div class="form-group">
						<input name="btnSubmit" type="submit" value="Đăng nhập" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
                    © 2019, Developed by <a href="https://aptech.cusc.vn">CUSC</a>
                </div>
			</div>
		</div>
	</div>
</div>
</body>
</html>