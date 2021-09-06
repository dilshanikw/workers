<?php
include 'connect.php';
include 'session.php';
error_reporting(0);
?>


<?php

if(isset($_POST['done']))
{
	echo "<script>				
			window.location.href='home.php';
		</script>";
}



$cur_dte=date("Y-m-d");

$query1 ="SELECT *,
				project.startDate AS prostartdte,
				 project.targetDate AS protragetdte,
				 task.startDate AS taskstartdte,
				 task.targetDate AS tasktragetdte
			FROM task INNER JOIN project ON task.projectID=project.projectID
			WHERE task.taskID='$_GET[sb]'";
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
	 $task_key=$queryinfo1['taskID'];
	 
$query2 ="SELECT *
			FROM staff WHERE empno='$proj_resperson'";
$result2=mysqli_query($link,$query2);
$queryinfo2=mysqli_fetch_assoc($result2);
	 $proj_respersonnme=$queryinfo2['firstname']." ".$queryinfo2['lastname'];
	 
	 
if(isset($_POST['submit']))
{
	
	
	$taskName = $_POST['subtaskName'];
	$taskDesc = $_POST['subtaskDesc'];
	$endDate = $_POST['subendDate'];
	

	if($task_traget>=$endDate){
			$query2 ="SELECT * FROM subtask  WHERE taskID='$_GET[sb]' AND projectID='$proj_id' AND subtaskName='$taskName' AND subtasktargetDate='$cur_dte'";
			$result2=mysqli_query($link,$query2);
			if(mysqli_num_rows($result2)==0){
				
				$query = "INSERT INTO `subtask` (`subtaskID`, 
											`taskID`, 
											`projectID`, 
											`subtaskName`, 
											`subtaskDesc`, 
											`subtaskstartDate`, 
											`subtasktargetDate`, 
											`subtask_status`, 
											`subtaskomplete_presentage`, 
											`create_dte`, 
											`create_by`) 
											VALUES (NULL, 
											'$_GET[sb]', 
											'$proj_id', 
											'$taskName', 
											'$taskDesc', 
											'$cur_dte',
											'$endDate', 
											'0', 
											'0', 
											current_timestamp(), 
											'$ses_ukey');";

				if(mysqli_query($link,$query))
				{
					$query4 ="SELECT * FROM subtask WHERE taskID='$_GET[sb]' AND projectID='$proj_id' AND subtaskName='$taskName'";
					$result4=mysqli_query($link,$query4);
					$queryinfo4=mysqli_fetch_assoc($result4);
					$subtask_idss1=$queryinfo4['subtaskID'];
					
					
					
					//echo '<script>alert("Data Inserted Sucessfully!");</script>';
					echo "<script>
									alert('Task Added Sucessfully!');
									window.location.href='new-subtask.php?sb=$_GET[sb]&ssb=$subtask_idss1';
						</script>";
					
				}
				else
				{
					$messagess="Something went wrong";
					$flagmsg=0;
				}
			}
			else
			{
					$messagess="Duplicate Project";
					$flagmsg=0;
			}
	}
	else{
		
		$messagess="Exceed Main Task Traget Date";
		$flagmsg=0;
	}
}


if(isset($_GET['ssb'])){
	
	$query8 ="SELECT * FROM subtask WHERE subtaskID='$_GET[ssb]'";
	$result8=mysqli_query($link,$query8);
	$queryinfo8=mysqli_fetch_assoc($result8);
						
		$subtask_traget1=$queryinfo8['subtasktargetDate'];
		$subtask_name=$queryinfo8['subtaskName'];
	
	if(isset($_POST['assigntask'])){
		
		$assign_person=$_POST['assign_person'];
		
		$query6 ="SELECT * FROM assign_subtask WHERE subtaskID='$_GET[ssb]' AND taskID='$_GET[sb]' AND projectID='$proj_id' AND staffID='$assign_person'";
		$result6=mysqli_query($link,$query6);
		if(mysqli_num_rows($result6)==0){
				
				$query7 = "INSERT INTO `assign_subtask` (
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
													'$_GET[ssb]', 
													'$_GET[sb]', 
													'$proj_id', 
													'$assign_person', 
													'$cur_dte', 
													'$subtask_traget1',
													'0',
													'0',
													'$ses_ukey', 
													current_timestamp());";
			if(mysqli_query($link,$query7))
			{
					
						$sql6=mysqli_query($link,"SELECT * FROM staff WHERE empno='$assign_person'");
						while($row6 = mysqli_fetch_array($sql6)){
							$staffemail=$row6['email'];
							$stafffname=$row6['firstname'];
							$stafflname=$row6['lastname'];
						}
						
						
						$to=$staffemail;
						
						
						$subject="A new subtask is assined - "."".$subtask_name." (".$task_nme.")";				//subject eka danna
						$msg1="Dear  ".$stafffname." ".$stafflname."\r\n"
							."A new subtask is assigned to you on ".$cur_dte.". The target finish date is ".$subtask_traget1.". \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							$messagess="&nbsp; Sucessfully Assign Staff Member and Message Sent!";
							$flagmsg=1;
						}
						else{
							$messagess="&nbsp; Sucessfully Assign Staff Member and Message Not Sent!";
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
			$messagess="Already Assign This Task";
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
  <title>WorkTracker | New Sub Task</title>

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
            <h1 class="m-0">New Sub Task</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">New Sub Task</li>
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
              <h3 class="card-title">Create New Sub Task</h3>

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
			

			
			<?php
			if($_GET['ssb']<=0){
			?>
					<div class="card-body">
					<form method="POST" name="f1">	
						<div class="form-group">
							<label for="taskName">Sub Task Name</label>
							<input type="text" id="taskName" name="subtaskName" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="taskDesc">Sub Task Description</label>
							<textarea id="taskDesc" name="subtaskDesc" class="form-control" rows="4"></textarea>
						</div>
						<!-- Start Date -->
						
						<!--End Date -->
						<div class="form-group">
						  <label>End Date:</label>
							<div class="input-group date col-md-6" id="endDate" name="endDate" data-inputmask-inputformat="mm/dd/yyyy" data-mask>
								<input type="date" name="subendDate" class="form-control datetimepicker-input" data-target="#endDate"/>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
							 
							  <input type="submit" value="Create Sub Task" name="submit" class="btn btn-success float">
							</div>
						</div>
					</form>
					</div>
				 
			<?php
			}
			else{
				
					$query5 ="SELECT *
								FROM subtask WHERE subtaskID='$_GET[ssb]'";
					$result5=mysqli_query($link,$query5);
					$queryinfo5=mysqli_fetch_assoc($result5);
						 $subtask_nme=$queryinfo5['subtaskName'];
						 $subtask_description=$queryinfo5['subtaskDesc'];
						 $subtask_start=$queryinfo5['subtaskstartDate'];
						 $subtask_traget=$queryinfo5['subtasktargetDate'];
					
			?>	
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
						  <th>Sub Task Start Date </th>
						  <td>: <?php echo  $subtask_start; ?></td>
						  <th>Sub Task Target Date</th>
						  <td>: <?php echo  $subtask_traget; ?></td>
						</tr>
						
					  </tbody>
					</table>
				</div>

					
					<form method="POST" name="f2">	
					<br>
					<br>
					<br>
						<div class="form-group">
							<label for="taskName">Staff Member</label>
							<label for="responsiblePerson">Responsible Person</label>
							<select name="assign_person" class="form-control" required>
								<?php
																
									$sql13="SELECT * FROM staff INNER JOIN assign_task ON staff.empno=assign_task.staff_ID
													 WHERE assign_task.task_ID='$_GET[sb]'
													ORDER BY staff.firstname ASC";
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
						
						<div class="row">
							<div class="col-12">
							  <input type="submit" value="Assign Task" name="assigntask" class="btn btn-success float">
							
							</div>
						</div>
						<br>
					</form>
					<form method="POST" name="f3">
						<div class="row">
							<div class="col-12">
							  
							  <input type="submit" value="Done" name="done" class="btn btn-danger float">
							</div>
						</div>

					</form>
					<br>
					<br>
					<br>
					<table>
						<?php 
						$sql1="SELECT * FROM assign_subtask INNER JOIN staff ON assign_subtask.staffID=staff.empno WHERE 
										assign_subtask.subtaskID='$_GET[ssb]'";
						$result1=mysqli_query($link,$sql1);
						while($row1=mysqli_fetch_array($result1)){
						?>
							<tr align="center">
								<td><?php echo $row1['firstname']." ".$row1['lastname']; ?></td>
							</tr>
						
						<?php
						}
						?>
					</table>
			<?php
			}
			?>
          <!-- /.card -->
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
