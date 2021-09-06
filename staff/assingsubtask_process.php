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
	
	$description = $_POST['assignsubtask_description'];
	$presentage = $_POST['assignsubtask_completepresentage'];
	
				$query = "INSERT INTO `staffsubtask_progress_details` (`subtaskprogress_ID`, `assigntaskID`, `subtaskID`, `taskID`, `projectID`, `staffID`, `description`, `presentage`, `submit_date`,`approve_status`,`staffsubtaskprogress_createdte`, `staffsubtaskprogress_createby`) 
									                   VALUES (NULL, '$_GET[as]', '$assignmsk_subtaskid', '$assignmsk_taskid', '$assignmsk_proid', '$ses_ukey', '$description', '$presentage', '$cur_dte','0',current_timestamp(), '1');";
				if(mysqli_query($link,$query))
				{
					$query4 ="SELECT *
								FROM staffsubtask_progress_details 
								WHERE assigntaskID='$_GET[as]'
								AND subtaskID='$assignmsk_subtaskid'
								AND taskID='$assignmsk_taskid'
								AND projectID='$assignmsk_proid'
								AND staffID='$ses_ukey'
								AND description='$description'
								AND presentage='$presentage'
								AND submit_date='$cur_dte'";
					$result4=mysqli_query($link,$query4);
					$queryinfo4=mysqli_fetch_assoc($result4);
					 
					$subtaskprocess_key=$queryinfo4['subtaskprogress_ID'];
					
					$query5 = "UPDATE `assign_subtask` SET complete_presentage='$presentage' WHERE assigntaskID='$_GET[as]'";
					mysqli_query($link,$query5);
					
					
					foreach($_FILES['upd_images']['name'] as $key=>$val){
						// File upload path
						$target_file = $target_dir.basename($_FILES['upd_images']['name'][$key]);

						// Check whether file type is valid
						$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
						$newimgkey=0;
						
						$sql29="SELECT MAX(staffsubtask_progress_image_details_key) AS maximagedetailkey FROM staffsubtask_progress_image_details";
						$result29= mysqli_query($link,$sql29);
						while($row29=mysqli_fetch_array($result29)){
							$mimgkeyos=$row29['maximagedetailkey'];
						}
						
						$newimgkey=$mimgkeyos+1;
						
						$target_new = $target_dir ."a".$newimgkey.".".$fileType;
						if (file_exists($target_new)) {
									
								echo "<script>
											alert('Sorry, file already exists.');
												
									</script>";
						}
						else{
								// Upload file to server
								if(move_uploaded_file($_FILES["upd_images"]["tmp_name"][$key], $target_new)){
											$awers1="a".$newimgkey.".".$fileType;
											$sql42="INSERT INTO   staffsubtask_progress_image_details   (staffsubtask_progress_image_details_key,subtaskprogress_ID,image_path,staffsubtask_progress_image_details_createby,staffsubtask_progress_image_details_createdte)
																		VALUES(NULL,'$subtaskprocess_key','$awers1','$ses_ukey',current_timestamp())";
											if(mysqli_query($link,$sql42)){
												
											}
											else{
												echo "<script>
													alert('Execute Error.');
												
												</script>";
											}
								}
						}
				   
					}
					
						$to=$cordinatior_email;
						
						
						$subject="Daily Progress Report has been submitted by ".$uadmin_first." ".$uadmin_last."";				//subject eka danna
						$msg1="Dear  Coordinator\r\n"
							."A daily progress report ".$subtaskname." has been submitted by ".$uadmin_first." ".$uadmin_last." at ".$cur_dte.". \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							$messagess="&nbsp; Sucessfully Send Progress Sub Task and Message Sent!";
							$flagmsg=1;
						}
						else{
							$messagess="&nbsp; Sucessfully Send Progress Sub Task and Message Not Sent!";
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
  <title>WorkTracker | Daily Report</title>

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
            <h1 class="m-0">Daily Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Daily Report</li>
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
              <h3 class="card-title">Daily Report</h3>

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
					<label for="projectName">Description</label>
					<textarea id="assignsubtask_description" name="assignsubtask_description" class="form-control" rows="4"></textarea>
				  
				</div>
				<div class="form-group">
					<label for="projectDesc">Complete Percentage</label>
					  <input type="number" max="100" min="0" id="assignsubtask_completepresentage" name="assignsubtask_completepresentage" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="projectDesc">Upload Documents</label>
					<input type="file" class="form-control input-lg" name="upd_images[]" multiple required>
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
