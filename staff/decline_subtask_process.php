<?php
include 'connect.php';
include 'session.php';
//error_reporting(0);

$cur_dte=date("Y-m-d");
?>


<?php
$query3 ="SELECT * FROM assign_subtask WHERE assigntaskID='$_GET[as]'";
$result3=mysqli_query($link,$query3);
$queryinfo3=mysqli_fetch_assoc($result3);
	$assignmsk_proid=$queryinfo3['projectID'];
	$assignmsk_subtaskid=$queryinfo3['subtaskID'];
	$assignmsk_taskid=$queryinfo3['taskID'];
	$assignmsk_date=$queryinfo3['assigntask_createdte'];
	$assignmsk_name=$queryinfo3['assigntask_createby'];
	
	$query7 ="SELECT *
			FROM coordinator WHERE codinator_key='$assignmsk_name'";
	$result7=mysqli_query($link,$query7);
	$queryinfo7=mysqli_fetch_assoc($result7);
	
	$assignmsk_by=$queryinfo7['first_name']." ".$queryinfo7['lastname'];
	
	
	
	$assignmsk_percentage=$queryinfo3['complete_presentage'];
	$assignmsk_targetdte=$queryinfo3['assigntask_targetdte'];
	
$query1 ="SELECT *,
				project.startDate AS prostartdte,
				 project.targetDate AS protragetdte,
				 task.startDate AS taskstartdte,
				 task.targetDate AS tasktragetdte
			FROM task INNER JOIN project ON task.projectID=project.projectID
			WHERE task.taskID='$assignmsk_taskid'";
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

$query6 ="SELECT * FROM subtask
							INNER JOIN project ON subtask.projectID=project.projectID
							INNER JOIN task ON subtask.taskID=task.taskID
							WHERE subtask.projectID='$assignmsk_proid'
							AND subtask.taskID='$assignmsk_taskid'";
							
$result6=mysqli_query($link,$query6);
$queryinfo6=mysqli_fetch_assoc($result6);
	 $subtaskname=$queryinfo6['subtaskName'];
	 $subtaskdesc=$queryinfo6['subtaskDesc'];
	 $subtaskstartdte=$queryinfo6['subtaskstartDate'];
	 $subtasktargetdte=$queryinfo6['subtasktargetDate'];
	
	 
$query2 ="SELECT *
			FROM staff WHERE empno='$proj_resperson'";
$result2=mysqli_query($link,$query2);
$queryinfo2=mysqli_fetch_assoc($result2);
	 $proj_respersonnme=$queryinfo2['firstname']." ".$queryinfo2['lastname'];
	 
$query8 ="SELECT *
			FROM coordinator WHERE user_level='Coordinator'";
$result8=mysqli_query($link,$query8);
$queryinfo8=mysqli_fetch_assoc($result8);
	$cordinatior_email=$queryinfo8['email'];
	$cordinatior_fulnme=$queryinfo8['firstname']." ".$queryinfo8['lastname'];	 

$target_dir ="upd_dailyreport/";
if(isset($_POST['submit'])){
	
	$description = $_POST['txt_decline_reason'];

	
				$query = "UPDATE assign_subtask SET decline_reason='$description',complete_status=3 WHERE assigntaskID='$_GET[as]'";
				if(mysqli_query($link,$query))
				{

					
						$to=$cordinatior_email;
						
						
						$subject="".$uadmin_first." ".$uadmin_last." has rejected the sub task ".$subtaskname." ";				//subject eka danna
						$msg1="Dear  Coordinator\r\n"
							."".$uadmin_first." ".$uadmin_last." has rejected the sub task ".$subtaskname." due to ".$description.". \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							$messagess="&nbsp; Sucessfully Decline Request Sub Task Progress and Message Sent!";
							$flagmsg=1;
						}
						else{
							$messagess="&nbsp; Sucessfully Decline Request Sub Task Progress and Message Not Sent!";
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
  <title>WorkTracker | Decline Sub Task</title>

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
            <h1 class="m-0">Decline Sub Task</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Decline Sub Task</li>
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
              <h3 class="card-title">Decline Sub Task</h3>

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
					  <td>: <?php echo  $subtaskname; ?></td>
					  <th>Sub Task Description</th>
					  <td>: <?php echo $subtaskdesc; ?></td>
					</tr>
					
					<tr>
					  <th>Start Date </th>
					  <td>: <?php echo  $subtaskstartdte; ?></td>
					  <th>Target Date</th>
					  <td>: <?php echo  $subtasktargetdte; ?></td>
					</tr>
					
				  </tbody>
				</table>
            </div>
			
			
			<br>
			<h5 align="center">Assign Details</h5>
			<div class="card-body p-0">
				<table class="table" border="1">
				  <tbody>
					<tr>
					  <th>Assignd Date </th>
					  <td>: <?php echo  $assignmsk_date; ?></td>
					  <th>Assigned By</th>
					  <td>: <?php echo $assignmsk_by; ?></td>
					</tr>
					
					<tr>
					  <th>Complete Percentage </th>
					  <td>: <?php echo  $assignmsk_percentage; ?>%</td>
					  <th>Target Date</th>
					  <td>: <?php echo  $assignmsk_targetdte; ?></td>
					</tr>
					
				  </tbody>
				</table>
            </div>
			<form role="form" method="Post" name="f4" enctype="multipart/form-data">
				<div class="form-group">
					<label for="projectName">Decline Reason</label>
					<textarea id="txt_decline_reason" name="txt_decline_reason" class="form-control" rows="4"></textarea>
				  
				</div>
				
				<!-- /.card-body -->
					<div class="row">
						<div class="col-12">
						  <input type="submit" value="Send" name="submit" class="btn btn-info">
						</div>
					</div>
			  <!-- /.card -->
			</form>
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
