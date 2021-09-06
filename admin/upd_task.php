<?php
include 'connect.php';
include 'session.php';
error_reporting(0);
?>


<?php


$cur_dte=date("Y-m-d");

$query1 ="SELECT *,
				project.startDate AS prostartdte,
				 project.targetDate AS protragetdte,
				 task.startDate AS taskstartdte,
				 task.targetDate AS tasktragetdte
			FROM task INNER JOIN project ON task.projectID=project.projectID
			WHERE task.taskID='$_GET[tkd]'";
$result1=mysqli_query($link,$query1);
$queryinfo1=mysqli_fetch_assoc($result1);
	 $proj_id=$queryinfo1['projectID'];
	 $proj_nme=$queryinfo1['projectName'];
	 $proj_des=$queryinfo1['projectDesc'];
	 $proj_start=$queryinfo1['prostartdte'];
	 $proj_traget=$queryinfo1['protragetdte'];
	 $proj_client=$queryinfo1['client'];
	 $proj_resperson=$queryinfo1['responsiblePerson'];
	 
	 
	 $task_nme=$queryinfo1['taskName'];
	 $task_description=$queryinfo1['taskDescription'];
	 $task_start=$queryinfo1['taskstartdte'];
	 $task_traget=$queryinfo1['tasktragetdte'];
	 $task_status=$queryinfo1['task_status'];
	 
$query2 ="SELECT *
			FROM staff WHERE empno='$proj_resperson'";
$result2=mysqli_query($link,$query2);
$queryinfo2=mysqli_fetch_assoc($result2);
	 $proj_respersonnme=$queryinfo2['firstname']." ".$queryinfo2['lastname'];
	 
	 
	if(isset($_POST['submit'])){
		$query1 = "UPDATE task SET taskName='$_POST[taskName]',
									taskDescription='$_POST[taskDesc]',
									startDate='$_POST[stDate]',
									targetDate='$_POST[endDate]'
								WHERE taskID='$_GET[tkd]'";
		if(mysqli_query($link,$query1)){
			
			$messagess="&nbsp; Sucessfully Update Task!";
			$flagmsg=1;
		}
		
	}
	
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Update Task</title>

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
            <h1 class="m-0">Update Task</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Task</li>
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
					  <h3 class="card-title">Update Task</h3>

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
					</div>
					<br>
					
					
					<div class="card-body">
					<form name="f1" method="post">
						<div class="form-group">
							<label for="taskName">Task Name</label>
							<input type="text" id="taskName" name="taskName" class="form-control" required value="<?php echo $task_nme; ?>">
						</div>
						<div class="form-group">
							<label for="taskDesc">Task Description</label>
							<textarea id="taskDesc" name="taskDesc" class="form-control" rows="4"><?php echo $task_description; ?></textarea>
						</div>
						<!-- Start Date -->
						<div class="form-group">
						  <label>Start Date:</label>
							<div class="input-group date col-md-6" id="stDate" name="stDate" data-inputmask-inputformat="mm/dd/yyyy" data-mask>
								<input type="date" name="stDate" class="form-control datetimepicker-input" data-target="#stDate" value="<?php echo $task_start; ?>"/>
							</div>
						</div>
						<!--End Date -->
						<div class="form-group">
						  <label>End Date:</label>
							<div class="input-group date col-md-6" id="endDate" name="endDate" data-inputmask-inputformat="mm/dd/yyyy" data-mask>
								<input type="date" name="endDate" class="form-control datetimepicker-input" data-target="#endDate" value="<?php echo $task_traget; ?>"/>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
							 
							  <input type="submit" value="Update Task" name="submit" class="btn btn-success float">
							</div>
						</div>
					</form>
					</div>
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
