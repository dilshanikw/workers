<!DOCTYPE html>

<?php
include("admin/connect.php");

session_start();
if(isset($_POST['submit'])){
	$username=$_POST['username'];

	 $sql3="SELECT * FROM coordinator WHERE user_level='admin'";
	 $result3=mysqli_query($link,$sql3);
	 $row3=mysqli_num_rows($result3);
	 $userinfo3=mysqli_fetch_assoc($result3);
	 $adminemaills=$userinfo3['email'];
	 
	 $sql1="SELECT * FROM staff WHERE user_name='$username'";
	 $result1=mysqli_query($link,$sql1);
	 $row1=mysqli_num_rows($result1);
	 $userinfo1=mysqli_fetch_assoc($result1);
	
	 $userid1=$userinfo1['empno'];
	 $useremail1=$userinfo1['email'];
	 $userfirstname1=$userinfo1['firstname'];
	 $userlastname1=$userinfo1['lastname'];
	 $useruser_name1=$userinfo1['user_name'];
	 
	
  
	if($row1==1){
		
		$query1 = "UPDATE staff SET resetpawrequest_status=1 WHERE empno='$userid1'";
		mysqli_query($link,$query1);
		
		$to=$adminemaills;
		
		$subject="Password Reset Requested";	
		$msg1="Admin \r\n"
							." ".$userfirstname1." ".$userlastname1." has sent a password reset request. Please reset the password of ".$userfirstname1." ".$userlastname1.", ".$useruser_name1." \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
		$ok3=mail($to,$subject,$msg1);
		if($ok3){
			$messagess="&nbsp; Sucessfully Reset Password and Message Sent!";
			$flagmsg=1;
		}
		else{
			$messagess="&nbsp; Sucessfully Reset Password and Message Not Sent!";
			$flagmsg=1;
		}
		
	}
	else{
		
			echo '<script>alert("Your User Name Invalid!");</script>'; 
		
	} 
}
 
?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="admin/plugins/toastr/toastr.min.css"><!-- Sweet Alert 2 -->
  <link rel="stylesheet" href="admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
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
				
				<div class="row">
				  <div class="col-1">
					
				  </div>
				  <!-- /.col -->
				  <div class="col-10">
					<button type="submit" name="submit" class="btn btn-primary btn-block">Request Password Reset</button>
				  </div>
				  <!-- /.col -->
				</div>
			  </form>
			  
			  <br>
			  <p class="mb-1" align="center">
				<a href="index.php">Login</a>
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
<script src="admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/dist/js/adminlte.min.js"></script>
<!-- Toastr -->
<script src="admin/plugins/toastr/toastr.min.js"></script>
<!-- SweetAlert2 -->
<script src="admin/plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>