<?php
include("connect.php");
include("session.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Reports</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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

	<?php include("topnavi.php");?>

  <!-- Main Sidebar Container -->
	<?php include("leftnavi.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Report Generation</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Reports</li>
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
							  <h3 class="card-title">Reports</h3>

							  <div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
								  <i class="fas fa-minus"></i>
								</button>
							  </div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3 col-sm-6 col-12">
									<div class="info-box">
									  <span class="info-box-icon bg-info"><i class="fas fa-folder-open"></i></span>

									  <div class="info-box-content">
										<a href="tcpdf/reports/staff_task_taskprogress.php" target="_blank"><span class="info-box-text">Personal Task Progress Report</span></a>
									  </div>
									  <!-- /.info-box-content -->
									</div>
									<!-- /.info-box -->
								</div>
								
								<div class="col-sm-3 col-sm-6 col-12">
									<div class="info-box">
									  <span class="info-box-icon bg-info"><i class="fas fa-folder-open"></i></span>

									  <div class="info-box-content">
										<a href="tcpdf/reports/staff_task_taskcompletion.php" target="_blank"><span class="info-box-text">Personal Task Completion Report</span></a>
									  </div>
									  <!-- /.info-box-content -->
									</div>
									<!-- /.info-box -->
								</div>
								  <!-- /.col -->
								<div class="col-sm-3 col-sm-6 col-12">
									<div class="info-box">
									  <span class="info-box-icon bg-info"><i class="fas fa-user-tie"></i></span>

									  <div class="info-box-content">
										<a href="tcpdf/reports/staff_project_projectcompletion.php" target="_blank"><span class="info-box-text">Personal Project Completion Report</span></a>
									  </div>
									  <!-- /.info-box-content -->
									</div>
									<!-- /.info-box -->
								</div>
								  <!-- /.col -->
								<div class="col-sm-3 col-sm-6 col-12">
									<div class="info-box">
									  <span class="info-box-icon bg-info"><i class="fas fa-portrait"></i></span>

									  <div class="info-box-content">
										<a href="rtp_employee_attendanceindividual.php" target="_blank"><span class="info-box-text">Personal Attendance Report</span></a>
									  </div>
									  <!-- /.info-box-content -->
									</div>
									<!-- /.info-box -->
								</div>
								  <!-- /.col -->
								<div class="col-sm-3 col-sm-6 col-12">
									<div class="info-box">
									  <span class="info-box-icon bg-info"><i class="fas fa-calendar-check"></i></span>

									  <div class="info-box-content">
										<a href="tcpdf/reports/employee_leavetakenindividual.php" target="_blank"><span class="info-box-text">Personal Leave Taking Report</span></a>
									  </div>
									  <!-- /.info-box-content -->
									</div>
									<!-- /.info-box -->
								</div>
								  <!-- /.col -->
								
							</div>
						</div>
						<!-- /.card -->
					</div>
					
				</div>
			</div>
			
			<?php
			if($ses_level=="Management Assistant"){
			?>
				<div class="row">
						<div class="col-md-12">
							<div class="card card-primary">
								<div class="card-header">
									  <h3 class="card-title">Management Assistant Reports</h3>

									  <div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
										  <i class="fas fa-minus"></i>
										</button>
									  </div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-sm-3 col-sm-6 col-12">
											<div class="info-box">
											  <span class="info-box-icon bg-info"><i class="fas fa-folder-open"></i></span>

											  <div class="info-box-content">
												<a href="rtp_super_employee_summary.php" target="_blank"><span class="info-box-text">Summary Attendance Report</span></a>
											  </div>
											  <!-- /.info-box-content -->
											</div>
											<!-- /.info-box -->
										</div>
										
										<div class="col-sm-3 col-sm-6 col-12">
											<div class="info-box">
											  <span class="info-box-icon bg-info"><i class="fas fa-folder-open"></i></span>

											  <div class="info-box-content">
												<a href="rtp_super_employee_attendanceindividual.php" target="_blank"><span class="info-box-text">Attendance Report - Staff Wise</span></a>
											  </div>
											  <!-- /.info-box-content -->
											</div>
											<!-- /.info-box -->
										</div>
										  <!-- /.col -->
										<div class="col-sm-3 col-sm-6 col-12">
											<div class="info-box">
											  <span class="info-box-icon bg-info"><i class="fas fa-user-tie"></i></span>

											  <div class="info-box-content">
												<a href="rtp_super_task_takenleaveindividual.php" target="_blank"><span class="info-box-text">Leave Report- Staff Wise</span></a>
											  </div>
											  <!-- /.info-box-content -->
											</div>
											<!-- /.info-box -->
										</div>
										  <!-- /.col -->
										
										
										
									</div>
								</div>
								<!-- /.card -->
							</div>
							
						</div>
				</div>
			<?php
			}
			?>
    </section>
   
	



           
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

<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>

</body>
</html>
