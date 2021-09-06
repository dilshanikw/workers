<?php
include 'connect.php';
include 'session.php';


?>


<?php
date_default_timezone_set('Asia/Kolkata');
$cur_dte=date("Y-m-d");

$outtime=date('Y-m-d H:i:s');


if(isset($_POST['submit']))
{
	

	
	$query2 = "SELECT * FROM attendance WHERE attendDate='$cur_dte' 
										 AND staffID='$ses_ukey'";
	$result2=mysqli_query($link,$query2);
	if(mysqli_num_rows($result2)==0){
		
		
			$query = "INSERT INTO `attendance` (`attendanceID`, 
											`attendDate`, 
											`staffID`, 
											`attendaneCreateDate`, 
											`attendaneCreateBy`) 
											VALUES (NULL, 
											'$cur_dte', 
											'$ses_ukey', 
											current_timestamp(),
											'$ses_ukey'
											);";
				if(mysqli_query($link,$query))
				{
					$messagess="&nbsp; Sucessfully Mark Attendance!";
					$flagmsg=1;
				}
				else
				{
					$messagess="Something went wrong";
					$flagmsg=0;
				}
	}
	else{
		$messagess="&nbsp; Already Mark Attendance";
		$flagmsg=0;
	}
	
}


if(isset($_POST['submit_out']))
{
				$query4 = "UPDATE attendance SET attendance_outdte='$outtime',attendance_outperson='$ses_ukey' WHERE attendDate='$cur_dte' AND staffID='$ses_ukey'";
				if(mysqli_query($link,$query4))
				{
					
					$query5 ="SELECT * FROM attendance WHERE attendDate='$cur_dte' AND staffID='$ses_ukey'";;
					$result5=mysqli_query($link,$query5);
					$queryinfo5=mysqli_fetch_assoc($result5);
					$in_tt=$queryinfo5['attendaneCreateDate'];
					$out_tt=$queryinfo5['attendance_outdte'];
					
						$in_tt1 = new DateTime($in_tt);
						$out_tt1   = new DateTime($out_tt); 
						
						$dteDiff11  = $in_tt1->diff($out_tt1); 
						
						$worktt11=$dteDiff11->format("%H:%I:%S");
					
						$to=$uemail;
						
						
						$subject="Your attendance report for ".$cur_dte."";				//subject eka danna
						$msg1="Dear  ".$uadmin_first." ".$uadmin_last."\r\n"
							."Today your in time is marked at ".$in_tt." and out time is marked at ".$out_tt.". Your total working hours for today is ".$worktt11.".\r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							$messagess="&nbsp; Sucessfully Mark Attendance and Message Sent!";
							$flagmsg=1;
						}
						else{
							$messagess="&nbsp; Sucessfully Mark Attendance and Message Not Sent!";
							$flagmsg=1;
						}
					
				}
				else
				{
					$messagess="Something went wrong";
					$flagmsg=0;
				}
	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Attendance</title>

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
            <h1 class="m-0">Attendance</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Attendance</li>
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
              <h3 class="card-title">Attendance</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
				<div class="form-group">
					<label>Current Date : <?php echo $outtime; ?></label>
					
				</div>
				<!-- /.card-body -->
			    <div class="row">
					<div class="col-12">
					<?php
					$query3 = "SELECT * FROM attendance WHERE attendDate='$cur_dte' 
															 AND staffID='$ses_ukey'";
					$result3=mysqli_query($link,$query3);
					if(mysqli_num_rows($result3)==0){
					?>
					  <input type="submit" value="Attendance" name="submit" class="btn btn-success float">
					<?php
					}
					else{

						$result5=mysqli_query($link,"SELECT * FROM attendance WHERE attendDate='$cur_dte' 
																			  AND staffID='$ses_ukey'");
						while($test5 = mysqli_fetch_array($result5))
						{
							$attendtt=$test5['attendaneCreateDate'];
						}
						
						$dteStart = new DateTime($attendtt);
						$dteEnd   = new DateTime($outtime); 
						
						$dteDiff  = $dteStart->diff($dteEnd); 
						
						$worktt=$dteDiff->format("%H:%I:%S");
					?>
						
						<label>In Time : <?php echo $attendtt; ?></label>
						<br>
						<label>Working Hours : <?php echo $worktt; ?></label>
						<br>
						<input type="submit" value="Out" name="submit_out" class="btn btn-danger float">
					
					<?php
					}
					?>
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
