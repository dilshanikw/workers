<?php
include 'connect.php';
include 'session.php';

if(isset($_POST['submit']))
{
	$staffID = $_POST['staffID'];
	$firstName = $_POST['FirstName'];
	$lastName = $_POST['LastName'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$address3 = $_POST['address3'];
	$city = $_POST['city'];
	$contactNo = $_POST['contactNo'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	
	$password=MD5(8888);
	
	$query2 = "SELECT * FROM coordinator WHERE staff_id='$staffID'";
	$result2=mysqli_query($link,$query2);
	if(mysqli_num_rows($result2)==0){
		
		$query3 = "SELECT * FROM coordinator WHERE user_name='$username'";
		$result3=mysqli_query($link,$query3);
		if(mysqli_num_rows($result3)==0){
			
			$query1 = "INSERT INTO `coordinator` (`codinator_key`, `staff_id`, `first_name`, `lastname`, `address1`, `address2`, `address3`, `city`, `contactno`, `email`, `profile_pic`, `user_name`, `password`, `user_level`, `createby`) VALUES
												(NULL, '$staffID', '$firstName', '$lastName', '$address1', '$address2', '$address3', '$city', '$contactNo', '$email', 'default.png', '$username', '$password', 'Coordinator', '$ses_ukey')";
			if(mysqli_query($link,$query1)){
				
					$messagess="Sucessfully Added Coordinator!";
					$flagmsg=1;
					
			}
			else{
					
					$messagess="Something went wrong";
					$flagmsg=0;
			}
		}
		else{
			
			$messagess="Sorry Duplicate User Name. Try Again";
			$flagmsg=0;
			
		}
	}
	else{
		$messagess="Already Added this User";
		$flagmsg=0;
	}
	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Create New Account</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Tempusdominus Bootstrap 4  css-->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition <?php echo $utheme?> sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/logo.png" alt="eLCLogo" height="60" width="60">
  </div>

  <!-- Navbar -->
	<?php include("topnavi.php");?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
	<?php include("leftnavi.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create Coordinator Account</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Account</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
	<!-- Main content -->
    <section class="content">
	<form name="f1" method="post">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Create Coordinator Account</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
				  <div class="form-group">
					<label for="staffID">Staff ID *</label>
					<input type="text" id="staffID" name="staffID" class="form-control" required>
				  </div>
				  <div class="form-group">
					<label for="FirstName">First Name *</label>
					<input type="text" id="FirstName" name="FirstName" class="form-control" required>
				  </div>
				  <div class="form-group">
					<label for="LastName">Last Name *</label>
					<input type="text" id="LastName" name="LastName" class="form-control" required>
				  </div>
				  <div class="form-group">
					<label for="address">Address *</label>
					<label for="address">Line No1 </label>
					<input type="text" id="address1" name="address1" class="form-control" placeholder="Line No1" required>
				  </div>
				  <div class="form-group">
					<label for="address"></label>
					<label for="address">Line No2 </label>
					<input type="text" id="address2" name="address2" class="form-control" placeholder="Line No2">
				  </div>
				  <div class="form-group">
					<label for="address"></label>
					<label for="address">Line No3 </label>
					<input type="text" id="address3" name="address3" class="form-control" placeholder="Line No3">
				  </div>
				  <div class="form-group">
					<label for="address"></label>
					<label for="address">City </label>
					<input type="text" id="city" name="city" class="form-control" placeholder="City">
				  </div>
				  <div class="form-group">
					<label for="contactNo">Contact Number *</label>
					<input type="text" id="contactNo" name="contactNo" class="form-control" required pattern="^\d{10}$">
				  </div>
					<div class="form-group">
						<label for="email">Email Address *</label>
						<input type="email" id="email" name="email" class="form-control">
					</div>
				  
					<div class="form-group">
						<label for="username">User Name *</label>
						<input type="text" id="username" name="username" class="form-control" required>
					</div>
		
					<div class="row">
							<div class="col-12">
							
							  <input type="submit" name="submit" value="Create Account" class="btn btn-success float">
							</div>
					</div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
	</form>
    </section>
    <!-- /.content -->
         
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 Dilshani Wijesiri.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!--Date Picker -->
	<script type="text/javascript" src="plugins/jquery/jquery.js"></script>
<!-- InputMask -->
	<script src="plugins/moment/moment.min.js"></script>
	<script src="plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 js -->
	<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
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
Toast.fire({
		<?php
		if($flagmsg==1){
		?>
			icon: 'success',
		<?php
		}
		else{
		?>
			icon: 'error',
		<?php
		}
		?>
        title: '<?php echo $messagess; ?>'
      })
</script>
</body>
</html>
