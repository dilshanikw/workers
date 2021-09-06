<?php
include 'connect.php';
include 'session.php';
?>


<?php
$cur_dte=date("Y-m-d");

$query8 ="SELECT *
			FROM coordinator WHERE user_level='Coordinator'";
$result8=mysqli_query($link,$query8);
$queryinfo8=mysqli_fetch_assoc($result8);
	$cordinatior_email=$queryinfo8['email'];
	$cordinatior_fulnme=$queryinfo8['firstname']." ".$queryinfo8['lastname'];


if(isset($_POST['submit']))
{
	

	$leaveStart = $_POST['leaveStartDate'];
	$leaveEnd = $_POST['leaveEndDate'];
	$reason = $_POST['reason'];

	
	$query2 = "SELECT * FROM leaves WHERE leaveStartDate='$leaveStart' 
										 AND staffID='$ses_ukey'";
	$result2=mysqli_query($link,$query2);
	if(mysqli_num_rows($result2)==0){
		
		if($leaveStart>$cur_dte){
			$query = "INSERT INTO `leaves` (`leaveID`, 
											`leaveStartDate`,
											`leaveEndDate`,
											`staffID`,
											`reason`,	
											`approvelStatus`, 
											`leavecreatedBy`, 
											`leavecreate_dte`) 
											VALUES (NULL, 
											'$leaveStart',
											'$leaveEnd',
											'$ses_ukey',
											'$reason',
											'0',
											'$ses_ukey',											
											current_timestamp()
											);";
				if(mysqli_query($link,$query))
				{
					
						$to=$cordinatior_email;
						
						
						$subject=" Leave Request is submitted by ".$uadmin_first." ".$uadmin_last."";				//subject eka danna
						$msg1="Dear  Coordinator\r\n"
							."".$uadmin_first." ".$uadmin_last." is requesting a leave on ".$leaveStart."-".$leaveEnd."  due to ".$reason."\r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							$messagess="&nbsp; Sucessfully Apply Leaves and Message Sent!";
							$flagmsg=1;
						}
						else{
							$messagess="&nbsp; Sucessfully Apply Leaves and Message Not Sent!";
							$flagmsg=1;
						}
				}
				else
				{
					$messagess="Something went wrong";
					$flagmsg=0;
				}
		}
		else{
			$messagess="&nbsp; Sorry Invalid Date Selection";
			$flagmsg=0;
		}
	}
	else{
		$messagess="&nbsp; Already Applied this Leaves";
		$flagmsg=0;
	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Apply Leaves</title>

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
  <!-- SweetAlert2 -->
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
            <h1 class="m-0">Apply Leaves</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Apply Leaves</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
	<!-- Main content -->
    <section class="content">
	<form method="POST">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Leaves</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
				<div class="form-group">
					<label>Leaves Start Date</label>
					<input type="date" id="leaveStartDate" name="leaveStartDate" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Reporting Date</label>
					<input type="date" id="leaveEndDate" name="leaveEndDate" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Reason</label>
					<input type="text" id="reason" name="reason" class="form-control" required>
				</div>
				<!-- /.card-body -->
			    <div class="row">
					<div class="col-12">
					  
					  <input type="submit" value="Apply Leaves" name="submit" class="btn btn-success float">
					</div>
				</div>
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
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
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
  position: 'middle',
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
