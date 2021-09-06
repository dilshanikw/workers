<?php
include 'connect.php';
include 'session.php';
error_reporting(0);
?>


<?php
$cur_dte=date("Y-m-d");




if(isset($_POST['submit']))
{
	
	$id =$_POST['projectddd'];
	$taskName = $_POST['taskName'];
	$taskDesc = $_POST['taskDesc'];
	$endDate = $_POST['endDate'];
	
	$query3 ="SELECT * FROM project WHERE projectID='$id'";
	$result3=mysqli_query($link,$query3);
	$queryinfo3=mysqli_fetch_assoc($result3);
	$proj_traget=$queryinfo3['targetDate'];
		

	$query2 ="SELECT * FROM task WHERE projectID='$id' AND taskName='$taskName' AND startDate='$cur_dte' AND task_status=0";
	$result2=mysqli_query($link,$query2);
	if(mysqli_num_rows($result2)==0){
		
		if($proj_traget>=$endDate){
			$query ="INSERT INTO `task` (`taskID`, `projectID`, `taskName`, `taskDescription`, `startDate`, `targetDate`, `endDate`, `task_status`, `complete_percent`, `create_dte`, `create_by`) VALUES ('0', '$id', '$taskName', '$taskDesc', '$cur_dte', '$endDate', NULL, '0', '0', current_timestamp(), '$ses_ukey')";
			if(mysqli_query($link,$query))
			{
				$query1 ="SELECT * FROM task WHERE projectID='$id' AND taskName='$taskName' AND startDate='$cur_dte' AND task_status=0";
				$result1=mysqli_query($link,$query1);
				$queryinfo1=mysqli_fetch_assoc($result1);
				$task_idss=$queryinfo1['taskID'];
				
				
				echo "<script>
								alert('Task Added Sucessfully!');
								window.location.href='new-task.php?td=$task_idss';
					</script>";
				
			}
			else
			{
				$messagess="Something went wrong";
				$flagmsg=0;
			}
		}
		else{
			$messagess="Exceed Project Traget Date";
			$flagmsg=0;
		}
	}
	else
	{
			$messagess="Duplicate Project";
			$flagmsg=0;
	}
}


if(isset($_GET['td'])){
	$query3 ="SELECT *,
				 project.startDate AS prostartdte,
				 project.targetDate AS protragetdte,
				 task.startDate AS taskstartdte,
				 task.targetDate AS tasktragetdte
					FROM task INNER JOIN project ON task.projectID=project.projectID
					WHERE task.taskID='$_GET[td]'";
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
	 
	$query2 ="SELECT *
			FROM staff WHERE empno='$proj_resperson'";
	$result2=mysqli_query($link,$query2);
	$queryinfo2=mysqli_fetch_assoc($result2);
			 $proj_respersonnme=$queryinfo2['firstname']." ".$queryinfo2['lastname'];
			 
			 
	if(isset($_POST['submit_assign'])){
		
		$assin_pr=$_POST['assign_person'];
		$endDate=$_POST['subendDate'];
		
		$query6 ="SELECT * FROM assign_task WHERE task_ID='$_GET[td]' AND project_id='$proj_id' AND staff_ID='$assin_pr'";
		$result6=mysqli_query($link,$query6);
		if(mysqli_num_rows($result6)==0){
		
			$query10 = "INSERT INTO `assign_task` (
													`assigntask_id`, 
													`task_ID`, 
													`project_id`, 
													`staff_ID`, 
													`taskassign_Date`, 
													`taskassign_targerDate`,
													`taskassign_complete_presentage`,
													`taskassign_complete_status`,
													`taskassign_createby`,
													`taskassign_createdte`) VALUES 
													(NULL,
													'$_GET[td]', 
													'$proj_id', 
													'$assin_pr', 
													'$cur_dte', 
													'$endDate',
													'0',
													'0',
													'$ses_ukey', 
													current_timestamp());";
			if(mysqli_query($link,$query10)){
					
					$sql5=mysqli_query($link,"SELECT * FROM staff WHERE empno='$assin_pr'");
					while($row5 = mysqli_fetch_array($sql5)){
						$staffemail=$row5['email'];
						$stafffname=$row5['firstname'];
						$stafflname=$row5['lastname'];
					}
						
						
						$to=$staffemail;
						
						
						$subject="A new task is assined - "."".$task_nme."";
						$msg1="Dear  ".$stafffname." ".$stafflname."\r\n"
							."A new task is assigned to you on ".$cur_dte.". The target finish date is ".$endDate.". \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							$messagess="&nbsp; Sucessfully Assign Task and Message Sent!";
							$flagmsg=1;
						}
						else{
							$messagess="&nbsp; Sucessfully Assign Task and Message Not Sent!";
							$flagmsg=1;
						}
				
				
			}
		}
		else{
			$messagess="&nbsp; Already Assign this Employee!";
				$flagmsg=0;
			
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | New Task</title>

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
            <h1 class="m-0">New Task</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Task</li>
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
              <h3 class="card-title">Create Task</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
				<?php
				if(isset($_GET['td'])){
				?>
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
					<form role="form" method="Post" name="f5">
					<br>
					<br>
						<div class="row">
							<div class="col-12">
								<select name="assign_person" class="form-control" required onchange="this.form.submit()">
									<?php
																	
										$sql13="SELECT * FROM staff ORDER BY firstname ASC";
										$result13=mysqli_query($link,$sql13);
										$option13 ="";
										while($row13=mysqli_fetch_array($result13)){
											
											
											$option13 = $option13."<option value=$row13[empno]>$row13[firstname] $row13[lastname] </option>";			//Load Branch
										}
																	
										if(isset($_POST['assign_person'])){
													$sql2="SELECT * FROM staff WHERE empno='$_POST[assign_person]' ORDER BY firstname ASC";
													$result2=mysqli_query($link,$sql2);
													$option2 ="";
													while($row2=mysqli_fetch_array($result2)){
														$option2 = $option2."<option value=$row2[empno]>$row2[firstname] $row2[lastname] </option>";
													}
												echo $option2;
												echo $option13;
										}
										else{
											echo "<option value='' disabled selected hidden>Please Choose.............</option>";
											echo $option13;
										}
																	
									?>
								</select>
								<br>
								<br>
								<?php
								if(isset($_POST['assign_person'])){
								?>
									<table class="table" border="1">
									  <tbody>
										<tr>
										  <th>Project Name</th>
										  <th>Task Name</th>
										  <th>Assign Date</th>
										  <th>Traget Date</th>
										  <th>Complete Status</th>
										</tr>
										<?php
										$sql3="SELECT * FROM assign_task INNER JOIN task ON assign_task.task_ID=task.taskID
																		 INNER JOIN project ON assign_task.project_id =project.projectID
																		WHERE assign_task.staff_ID='$_POST[assign_person]' 
																		AND assign_task.taskassign_complete_status=0";
										$result3=mysqli_query($link,$sql3);
										if(mysqli_num_rows($result3)==0){
										?>
											<tr>
												<td colspan="5" align="center">Not Assign Task</td>
											</tr>
										<?php
										}
										else{
										while($row3=mysqli_fetch_array($result3)){
										?>
											<tr>
											  
											  <td><?php echo $row3['projectName']?></td>
											  <td><?php echo $row3['taskName']?></td>
											  <td><?php echo $row3['taskassign_Date']?></td>
											  <td><?php echo $row3['taskassign_targerDate']?></td>
											  <td><?php echo $row3['taskassign_complete_presentage']?>%</td>
											  
											</tr>
										<?php
										}
										}
										?>
									  </tbody>
									</table>
								<?php
								}
								?>
							</div>
							
							<div class="col-12">
								<label>Traget Date:</label>
								
								<input type="date" name="subendDate" class="form-control"/>
								<br>
								<br>
							</div>
							
							<div class="col-12">

							  <input type="submit" value="Assign" name="submit_assign" class="btn btn-success float">
							</div>
						</div>
					</form>
				<?php
				}
				else{
				?>
					<div class="form-group">
					  <label for="selectproject">Select Project</label>
					  <select class="form-control" name="projectddd" id="projectID" style="width: 100%;">
						<?php
														
							$sql13="SELECT * FROM project WHERE project_status=0 ORDER BY projectID ASC";
							$result13=mysqli_query($link,$sql13);
							$option13 ="";
							while($row13=mysqli_fetch_array($result13)){
								$option13 = $option13."<option value=$row13[projectID]>$row13[projectName]-$row13[client]</option>";			//Load Projects
							}
														
														
							echo "<option value='' disabled selected hidden>Please Choose.............</option>";
							echo $option13;
														
						?>

					  </select>
					</div>
					<div class="form-group">
						<label for="taskName">Task Name</label>
						<input type="text" id="taskName" name="taskName" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="taskDesc">Task Description</label>
						<textarea id="taskDesc" name="taskDesc" class="form-control" rows="4"></textarea>
					</div>
					<!-- Start Date -->
					
					<!--End Date -->
					<div class="form-group">
					  <label>End Date:</label>
						<div class="input-group date col-md-6" id="endDate" name="endDate" data-inputmask-inputformat="mm/dd/yyyy" data-mask>
							<input type="date" name="endDate" class="form-control datetimepicker-input" data-target="#endDate"/>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
						 
						  <input type="submit" value="Create Task" name="submit" class="btn btn-success float">
						</div>
					</div>
				<?php
				}
				?>
				<br>
				<br>
				<table>
						<?php 
						$sql4="SELECT * FROM assign_task INNER JOIN staff ON assign_task.staff_ID=staff.empno WHERE 
										assign_task.task_ID='$_GET[td]'";
						$result4=mysqli_query($link,$sql4);
						while($row4=mysqli_fetch_array($result4)){
						?>
							<tr align="center">
								<td><?php echo $row4['firstname']." ".$row4['lastname']; ?></td>
							</tr>
						
						<?php
						}
						?>
				</table>
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
