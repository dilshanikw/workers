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
				  
					FROM staffsubtask_progress_details INNER JOIN assign_subtask ON staffsubtask_progress_details.assigntaskID=assign_subtask.assigntaskID
													  INNER JOIN subtask ON staffsubtask_progress_details.subtaskID=subtask.subtaskID
													  INNER JOIN task ON staffsubtask_progress_details.taskID=task.taskID
													  INNER JOIN project ON staffsubtask_progress_details.projectID =project.projectID
													  INNER JOIN staff ON staffsubtask_progress_details.staffID=staff.empno
													WHERE staffsubtask_progress_details.subtaskprogress_ID='$_GET[dr]'";
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
	 
	 $assignsubtask_id=$queryinfo3['assigntaskID'];
	 $assignsubtask_tragetdte=$queryinfo3['assigntask_targetdte'];
	 $assignsubtask_completepresenrage=$queryinfo3['complete_presentage'];
	 $assignsubtask_description=$queryinfo3['description'];
	 $assignsubtask_individualpresentage=$queryinfo3['presentage'];
	 $assignsubtask_submit=$queryinfo3['submit_date'];
	 $assignsubtask_empname=$queryinfo3['firstname']." ".$queryinfo3['lastname'];
	 $assignsubtask_empmail=$queryinfo3['email'];
	 $assignsubtask_empfnme=$queryinfo3['firstname'];
	 $assignsubtask_emplnme=$queryinfo3['lastname'];
	 
	 
	 $assignsubtask_subtaskkid=$queryinfo3['subtaskID'];
	 $assignsubtask_taskkid=$queryinfo3['taskID'];
	 $assignsubtask_projjid=$queryinfo3['projectID'];
	 
	 
$query2 ="SELECT *
			FROM staff WHERE empno='$proj_resperson'";
$result2=mysqli_query($link,$query2);
$queryinfo2=mysqli_fetch_assoc($result2);
	 $proj_respersonnme=$queryinfo2['firstname']." ".$queryinfo2['lastname'];
	 
	 

	if(isset($_POST['submit_approve'])){
			$ss1=$_POST['txt_feedback'];
			$query7 = "UPDATE staffsubtask_progress_details SET approve_status=1,feedback='$ss1' WHERE subtaskprogress_ID='$_GET[dr]'";
			if(mysqli_query($link,$query7))
			{
				if($assignsubtask_individualpresentage==100){
					
					$query8 = "UPDATE assign_subtask SET complete_status=1 WHERE assigntaskID='$assignsubtask_id'";
					mysqli_query($link,$query8);
				}
					
					
						$to=$assignsubtask_empmail;
						
						
						$subject="The daily progress report ".$subtask_nme." for ".$cur_dte." is approved";				//subject eka danna
						$msg1="Dear  ".$assignsubtask_empfnme." ".$assignsubtask_emplnme."\r\n"
							."The daily report for the subtask ".$subtask_nme." you submitted on ".$assignsubtask_submit." is approved by the coordinator. \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							$messagess="&nbsp; Sucessfully Approve Task and Message Sent!";
							$flagmsg=1;
						}
						else{
							$messagess="&nbsp; Sucessfully Approve Task and Message Not Sent!";
							$flagmsg=1;
						}
			}
		
	}
	if(isset($_POST['submit_reject'])){
			$ss1=$_POST['txt_feedback'];
			$query4 = "UPDATE staffsubtask_progress_details SET approve_status=2,feedback='$ss1' WHERE subtaskprogress_ID='$_GET[dr]'";
			if(mysqli_query($link,$query4))
			{
					
						$to=$assignsubtask_empmail;
						
						
						$subject="The daily progress report ".$subtask_nme." for ".$cur_dte." is declined";				//subject eka danna
						$msg1="Dear  ".$assignsubtask_empfnme." ".$assignsubtask_emplnme."\r\n"
							."The daily report for the subtask ".$subtask_nme." you submitted on ".$assignsubtask_submit." is declined by the coordinator. \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							$messagess="&nbsp; Sucessfully Rejected Task and Message Sent!";
							$flagmsg=1;
						}
						else{
							$messagess="&nbsp; Sucessfully Rejected Task and Message Not Sent!";
							$flagmsg=1;
						}
			}
		
	}
	
	
	if(isset($_POST['submit_reassign'])){
		
		$assin_pr=$_POST['assign_person'];
		$subendDate=$_POST['subendDate'];
		
		$query11 ="SELECT * FROM assign_subtask WHERE subtaskID='$assignsubtask_subtaskkid' AND taskID='$assignsubtask_taskkid' AND projectID='$assignsubtask_projjid' AND staffID='$assin_pr'";
		$result11=mysqli_query($link,$query11);
		if(mysqli_num_rows($result11)==0){
			
			$query9 = "UPDATE assign_subtask SET complete_status=2 WHERE assigntaskID='$assignsubtask_id'";
			if(mysqli_query($link,$query9)){
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
														'$assignsubtask_subtaskkid', 
														'$assignsubtask_taskkid', 
														'$assignsubtask_projjid', 
														'$assin_pr', 
														'$cur_dte', 
														'$subendDate',
														'0',
														'0',
														'$ses_ukey', 
														current_timestamp());";
				mysqli_query($link,$query10);
				
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
			
			
			
			<br>
			<h5 align="center">Assign Details</h5>
			<div class="card-body p-0">
				<table class="table" border="1">
				  <tbody>
					<tr>
					  <th>Staff </th>
					  <td>: <?php echo  $assignsubtask_empname; ?></td>
					  <th>Target Date</th>
					  <td>: <?php echo $assignsubtask_tragetdte; ?></td>
					</tr>
					
					<tr>
					  <th>Complete Percentage </th>
					  <td>: <?php echo  $assignsubtask_completepresenrage; ?>%</td>
					  <th>Submit Date</th>
					  <td>: <?php echo  $assignsubtask_submit; ?></td>
					</tr>
					<tr>
					  <th>Description </th>
					  <td>: <?php echo  $assignsubtask_description; ?></td>
					  <th>Percentage</th>
					  <td>: <?php echo  $assignsubtask_individualpresentage; ?>%</td>
					</tr>
				  </tbody>
				</table>
            </div>
			
			<br>
			<h5 align="center">Related Documents</h5>
			<div class="card-body p-0">
				<table class="table" border="1">
					
				  <tbody>
					<?php
					$n1=0;
					$result4=mysqli_query($link,"SELECT * FROM staffsubtask_progress_image_details WHERE subtaskprogress_ID='$_GET[dr]'");
					while($test4 = mysqli_fetch_array($result4))
					{
						$n1++;
					?>
						<tr>
							<td><a href="../staff/upd_dailyreport/<?php echo $test4['image_path'];?>" target="_blank"> Document <?php echo $n1;?></a></td>
						</tr>
					<?php
					}
					?>
				  </tbody>
				</table>
            </div>
			
			
			<form role="form" method="Post" name="f4">
					<br>
					<div class="row">
						<div class="col-12">
							<label>Feedback </label>
							
							<textarea name="txt_feedback" class="form-control"/></textarea>
							
						</div>
						<br>
						<div class="col-12">

						  <input type="submit" value="Approve" name="submit_approve" class="btn btn-success float">
						  <br>
						  <br>
						</div>
						
						<div class="col-12">

						  <input type="submit" value="Reject" name="submit_reject" class="btn btn-danger float">
						</div>
					</div>
			</form>
			<form role="form" method="Post" name="f5">
					<br>
					<div class="row">
						<div class="col-12">
							<select name="assign_person" class="form-control" required>
								<?php
																
									$sql13="SELECT * FROM staff ORDER BY firstname ASC";
									$result13=mysqli_query($link,$sql13);
									$option13 ="";
									while($row13=mysqli_fetch_array($result13)){
										$option13 = $option13."<option value=$row13[empno]>$row13[firstname] $row13[lastname]</option>";			//Load Branch
									}
																
																
									echo "<option value='' disabled selected hidden>Please Choose.............</option>";
									echo $option13;
																
								?>
							</select>
						</div>
						<br>
						<div class="col-12">
							<label>End Date:</label>
							
							<input type="date" name="subendDate" class="form-control"/>
							
						</div>
						<br>
						<div class="col-12">

						  <input type="submit" value="Reassign" name="submit_reassign" class="btn btn-danger float">
						</div>
					</div>
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
