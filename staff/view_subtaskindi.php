<?php
include 'connect.php';
include 'session.php';
//error_reporting(0);

$cur_dte=date("Y-m-d");
?>


<?php
$query3 ="SELECT *,
				 project.startDate AS prostartdte,
				 project.targetDate AS protragetdte,
				 task.startDate AS taskstartdte,
				 task.targetDate AS tasktragetdte
					FROM subtask INNER JOIN task ON subtask.taskID=task.taskID
								 INNER JOIN project ON subtask.projectID =project.projectID
					WHERE subtask.subtaskID='$_GET[sb]'";
$result3=mysqli_query($link,$query3);
$queryinfo3=mysqli_fetch_assoc($result3);

	 $proj_id=$queryinfo3['projectID'];
	 $proj_nme=$queryinfo3['projectName'];
	 $proj_des=$queryinfo3['projectDesc'];
	 $proj_start=$queryinfo3['prostartdte'];
	 $proj_traget=$queryinfo3['protragetdte'];
	 $proj_client=$queryinfo3['client'];
	 $proj_resperson=$queryinfo3['responsiblePerson'];
	 
	 
	 $task_nme=$queryinfo3['taskName'];
	 $task_description=$queryinfo3['taskDescription'];
	 $task_start=$queryinfo3['taskstartdte'];
	 $task_traget=$queryinfo3['tasktragetdte'];
	 
	 $subtask_nme=$queryinfo3['subtaskName'];
	 $subtask_description=$queryinfo3['subtaskDesc'];
	 $subtask_start=$queryinfo3['subtaskstartDate'];
	 $subtask_traget=$queryinfo3['subtasktargetDate'];
	 
	 
	  
	 $taskkids=$queryinfo3['taskID'];
	 $projectss_id=$queryinfo3['projectID'];
	
	 
$query2 ="SELECT *
			FROM staff WHERE empno='$proj_resperson'";
$result2=mysqli_query($link,$query2);
$queryinfo2=mysqli_fetch_assoc($result2);
	 $proj_respersonnme=$queryinfo2['firstname']." ".$queryinfo2['lastname'];
	 
	
	if(isset($_POST['submit_complete'])){
		$query1 = "UPDATE subtask SET subtask_status=1,subtaskendDate='$cur_dte' WHERE subtaskID='$_GET[sb]'";
		if(mysqli_query($link,$query1)){

			$query4 = "UPDATE assign_subtask SET complete_status=1 WHERE subtaskID='$_GET[sb]'";
			mysqli_query($link,$query4);
			
			$query5 = "UPDATE staffsubtask_progress_details SET approve_status=1 WHERE subtaskID='$_GET[sb]'";
			mysqli_query($link,$query5);
			
			$messagess="&nbsp; Sucessfully Complete Sub Task!";
			$flagmsg=1;
		}
		
	}
	
	if(isset($_POST['submit_cancel'])){
		
		$query1 = "UPDATE subtask SET subtask_status=2 WHERE subtaskID='$_GET[sb]'";
		if(mysqli_query($link,$query1)){
			
			
			$query4 = "UPDATE assign_subtask SET complete_status=2 WHERE subtaskID='$_GET[sb]'";
			mysqli_query($link,$query4);
			
			$query5 = "UPDATE staffsubtask_progress_details SET approve_status=2 WHERE subtaskID='$_GET[sb]'";
			mysqli_query($link,$query5);
			
			$messagess="&nbsp; Sucessfully Cancel Sub Task!";
			$flagmsg=1;
		}
		
	}

	
	if(isset($_POST['submit_assign'])){
		
		$assin_pr=$_POST['assign_person'];
		$subendDate=$_POST['subendDate'];
		
		$query6 ="SELECT * FROM assign_subtask WHERE subtaskID='$_GET[sb]' AND taskID='$taskkids' AND projectID='$projectss_id' AND staffID='$assin_pr'";
		$result6=mysqli_query($link,$query6);
		if(mysqli_num_rows($result6)==0){
		
			$query10 = "INSERT INTO `assign_subtask` (
													`assigntaskID`, 
													`subtaskID`, 
													`taskID`, 
													`projectID`, 
													`staffID`, 
													`assign_dte`, 
													`assigntask_targetdte`,
													`complete_presentage`,
													`complete_status`,
													`assigntask_createby`,
													`assigntask_createdte`) VALUES 
													(NULL,
													'$_GET[sb]', 
													'$taskkids', 
													'$projectss_id', 
													'$assin_pr', 
													'$cur_dte', 
													'$subendDate',
													'0',
													'0',
													'$ses_ukey', 
													current_timestamp());";
			if(mysqli_query($link,$query10)){
			
				$messagess="&nbsp; Sucessfully Reassign Task!";
				$flagmsg=1;
			}
		}
		else{
			$messagess="&nbsp; Already Assign this Employee!";
				$flagmsg=0;
			
		}
	}
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Sub Task</title>

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
            <h1 class="m-0">Sub Task</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sub Task</li>
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
              <h3 class="card-title">Sub Task</h3>

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
			
			
			
			<h5 align="center">Task Details</h5>
			<div class="card-body p-0">
				<table class="table" border="1">
				  <tbody>
					<tr>
					  <th>Task Name </th>
					  <td>: <?php echo  $task_nme; ?></td>
					  <th>Task Description</th>
					  <td>: <?php echo $task_description; ?></td>
					</tr>
					
					<tr>
					  <th>Start Date </th>
					  <td>: <?php echo  $task_start; ?></td>
					  <th>Target Date</th>
					  <td>: <?php echo  $task_traget; ?></td>
					</tr>
					
				  </tbody>
				</table>
            </div>
			
			
			
			<br>
			<h5 align="center">Sub Task Details</h5>
			<div class="card-body p-0">
				<table class="table" border="1">
				  <tbody>
					<tr>
					  <th>Sub Task Name </th>
					  <td>: <?php echo  $subtask_nme; ?></td>
					  <th>Sub Task Description</th>
					  <td>: <?php echo $subtask_description; ?></td>
					</tr>
					
					<tr>
					  <th>Start Date </th>
					  <td>: <?php echo  $subtask_start; ?></td>
					  <th>Target Date</th>
					  <td>: <?php echo  $subtask_traget; ?></td>
					</tr>
					
				  </tbody>
				</table>
            </div>
			
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
