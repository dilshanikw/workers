<?php
include 'connect.php';
include 'session.php';
error_reporting(0);
?>


<?php


$cur_dte=date("Y-m-d");

$query1 ="SELECT * FROM project WHERE projectID='$_GET[pr]'";
$result1=mysqli_query($link,$query1);
$queryinfo1=mysqli_fetch_assoc($result1);
	 $proj_id=$queryinfo1['projectID'];
	 $proj_nme=$queryinfo1['projectName'];
	 $proj_des=$queryinfo1['projectDesc'];
	 $proj_start=$queryinfo1['startDate'];
	 $proj_traget=$queryinfo1['targetDate'];
	 $proj_client=$queryinfo1['client'];
	 $proj_resperson=$queryinfo1['responsiblePerson'];
	 
	 
$query2 ="SELECT *
			FROM staff WHERE empno='$proj_resperson'";
$result2=mysqli_query($link,$query2);
$queryinfo2=mysqli_fetch_assoc($result2);
	 $proj_respersonnme=$queryinfo2['firstname']." ".$queryinfo2['lastname'];
	 
	 

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Project Task</title>

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
            <h1 class="m-0">Project Task</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Project Task</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
	<!-- Main content -->
    <section class="content">
	
		<div class="row">
			<div class="col-md-12">
				  <div class="card card-primary">
					<div class="card-header">
					  <h3 class="card-title">Project Task</h3>

					  <div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						  <i class="fas fa-minus"></i>
						</button>
					  </div>
					</div>
					
					<h5 align="center">Project Details</h5>
					<div class="card-body p-0">
						<table class="table" border="1">
						  <tbody>
							<tr>
							  <th>Project Name </th>
							  <td>: <?php echo  $proj_nme; ?></td>
							  <th>Project Description</th>
							  <td>: <?php echo $proj_des; ?></td>
							</tr>
							
							<tr>
							  <th>Start Date </th>
							  <td>: <?php echo  $proj_start; ?></td>
							  <th>Target Date</th>
							  <td>: <?php echo  $proj_traget; ?></td>
							</tr>
							
							<tr>
							  <th>Client</th>
							  <td>: <?php echo  $proj_client; ?></td>
							  <th>Responsible Person</th>
							  <td>: <?php echo  $proj_respersonnme; ?></td>
							</tr>
							
						  </tbody>
						</table>
						<br>
						<br>
						<table class="table" border="1">
							<thead>
								<tr>
									<th> No </th>
									<th> Task </th>
									<th> Task Description </th>
									<th> Start Date </th>
									<th> End Date </th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=0;
								$result4=mysqli_query($link,"SELECT * FROM task WHERE projectID='$_GET[pr]'");
								while($test4 = mysqli_fetch_array($result4))
								{
									$no++;
									
									echo "<tr>";
										echo"<td>" .$no."</td>";
										echo"<td>" .$test4['taskName']."</td>";
										echo"<td>" .$test4['taskDescription']."</td>";
										echo"<td>" .$test4['startDate']."</td>";
										echo"<td>" .$test4['targetDate']."</td>";
											
									echo "</tr>";
								}
								?>
							</tbody>
						</table>
					</div>
					<br>
					
					
				  <!-- /.card -->
				</div>
			</div>
		</div>	
		

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
