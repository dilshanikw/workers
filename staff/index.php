<!DOCTYPE html>

<?php
include("connect.php");

session_start();
if(isset($_POST['submit'])){
	$username=$_POST['username'];
	$password=MD5($_POST['password']);
	//Protect MySQL Injection
	 
	$username=stripcslashes($username);
	$username=mysqli_real_escape_string($link,$username);
	$username=htmlspecialchars($username);
  
	$password=stripcslashes($password);
	$password=mysqli_real_escape_string($link,$password);
	$password=htmlspecialchars($password);
	
	
	 $sql="SELECT * FROM coordinator WHERE user_name='$username' AND password='$password'";
	 $result=mysqli_query($link,$sql);
	 $row=mysqli_num_rows($result);
	 $userinfo=mysqli_fetch_assoc($result);
	 $role=$userinfo['user_level'];
	 $userid=$userinfo['codinator_key'];
	 $userpsw=$userinfo['password'];
	 
	 $maxpprifix_cordinatior = sprintf('%04d',$userid);	
	 $reste_cordinatior=MD5($maxpprifix_cordinatior);
	 // check condinator login
	 
	 $sql1="SELECT * FROM staff WHERE user_name='$username' AND password='$password'";
	 $result1=mysqli_query($link,$sql1);
	 $row1=mysqli_num_rows($result1);
	 $userinfo1=mysqli_fetch_assoc($result1);
	 $role1=$userinfo1['user_level'];
	 $userid1=$userinfo1['empno'];
	 $userpsw1=$userinfo1['password'];
	 
	 $maxpprifix_staff = sprintf('%04d',$userid1);	
	 $reste_staff=MD5($maxpprifix_staff);
	  // check staff login
	
	
  
	if($row==1){
	 
	  $_SESSION['login_user']=$username;
	  $_SESSION['user_level']=$role;
	  $_SESSION['user_key']=$userid;
	  
		if($userpsw==$reste_cordinatior){
			header("location:../admin/newpassword.php");
			session_register("username","user_level","user_keye");
		}
		else{
			header("location:../admin/dashboard");
			session_register("username","user_level","user_keye");
		}
	  
	   
	}
	else if($row1==1){
		$_SESSION['login_user']=$username;
		$_SESSION['user_level']=$role1;
		$_SESSION['user_key']=$userid1;
	  
		if($userpsw1==$reste_staff){
		  	header("location:../staff/newpassword.php");
			session_register("username","user_level","user_keye");
		}
		else{
			header("location:../staff/home.php");
			session_register("username","user_level","user_keye");
		}
		
	}
	else{
		$sql2="SELECT * FROM coordinator WHERE user_name='$username'";
		$result2=mysqli_query($link,$sql2);
		$row2=mysqli_num_rows($result2);
		
		$sql3="SELECT * FROM staff WHERE user_name='$username'";
		$result3=mysqli_query($link,$sql3);
		$row3=mysqli_num_rows($result3);
		
		if($row2==1){
			echo '<script>alert("Invalid Password!");</script>';
		}
		else if($row3==1){
			echo '<script>alert("Invalid Password!");</script>';
		}
		else{
			echo '<script>alert("Your User Name Password Invalid!");</script>'; 
		}
	} 
}
 
?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>eLc | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css"><!-- Sweet Alert 2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>
<body class="hold-transition login-page">

	<div class="login-box">
		<div class="login-logo">
			<img src="admin/dist/img/logo.png">
		</div>
	  <!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
			  <p class="login-box-msg">Sign in to start your session</p>

			  <form action="" method="post">
				<div class="input-group mb-3">
				  <input type="text" name="username" class="form-control" placeholder="User Name">
				  <div class="input-group-append">
					<div class="input-group-text">
					  <span class="fas fa-user"></span>
					</div>
				  </div>
				</div>
				<div class="input-group mb-3">
				  <input type="password" name="password" class="form-control" placeholder="Password">
				  <div class="input-group-append">
					<div class="input-group-text">
					  <span class="fas fa-lock"></span>
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-4">
					
				  </div>
				  <!-- /.col -->
				  <div class="col-4">
					<button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
				  </div>
				  <!-- /.col -->
				</div>
			  </form>
			  
			  <br>
			  <p class="mb-1" align="center">
				<a href="froget_password.php">I forgot my password</a>
			  </p>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
<!-- /.login-box -->



<script>
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

			  

</script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>