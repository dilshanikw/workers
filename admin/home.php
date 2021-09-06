<?php
include("connect.php");
include("session.php");
?>

<?php

	$result2=mysqli_query($link,"SELECT * FROM leaves INNER JOIN staff ON leaves.staffID=staff.empno
																WHERE leaves.approvelStatus=0");
	while($test2 = mysqli_fetch_array($result2))
	{
			$aa_key1="aa_key".$test2['leaveID'];
			$aa_btn1="aa_btn".$test2['leaveID'];
			
			$d_key1="d_key".$test2['leaveID'];
			$d_btn1="d_btn".$test2['leaveID'];
			
		if(isset($_POST[$aa_btn1])){
			$query2 = "UPDATE leaves SET approvelStatus=1 WHERE leaveID='$_POST[$aa_key1]'";
			if(mysqli_query($link,$query2))
			{
					
					
				$result4=mysqli_query($link,"SELECT * FROM leaves INNER JOIN staff ON leaves.staffID=staff.empno
																WHERE leaves.leaveID='$_POST[$aa_key1]'");
				while($test4 = mysqli_fetch_array($result4))
				{
					$stafffname=$test4['firstname'];
					$stafflname=$test4['lastname'];
					$leavecreate_dte=$test4['leavecreate_dte'];
					$leaveStartDate=$test4['leaveStartDate'];
					$leaveEndDate=$test4['leaveEndDate'];
					$to=$test4['email'];
				}
				
					$subject="The leave requested is approved";		
					$msg1="Dear  ".$stafffname." ".$stafflname."\r\n"
							."The leave you requested on ".$leavecreate_dte." for date ".$leaveStartDate." - ".$leaveEndDate." is approved by the coordinator.. \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
					$ok3=mail($to,$subject,$msg1);
					if($ok3){
							$messagess="&nbsp; Sucessfully Approve Leaves and Message Sent!";
							$flagmsg=1;
					}
					else{
							$messagess="&nbsp; Sucessfully Approve Leaves and Message Not Sent!";
							$flagmsg=1;
					}
			}
			else
			{
					$messagess="Something went wrong";
					$flagmsg=0;
			}
		}
		if(isset($_POST[$d_btn1])){
			$query3 = "UPDATE leaves SET approvelStatus=2 WHERE leaveID='$_POST[$d_key1]'";
			if(mysqli_query($link,$query3))
			{
				$result4=mysqli_query($link,"SELECT * FROM leaves INNER JOIN staff ON leaves.staffID=staff.empno
																WHERE leaves.leaveID='$_POST[$d_key1]'");
				while($test4 = mysqli_fetch_array($result4))
				{
					$stafffname=$test4['firstname'];
					$stafflname=$test4['lastname'];
					$leavecreate_dte=$test4['leavecreate_dte'];
					$leaveStartDate=$test4['leaveStartDate'];
					$leaveEndDate=$test4['leaveEndDate'];
					$to=$test4['email'];
				}
				
					$subject="The leave requested is declined";	
					$msg1="Dear  ".$stafffname." ".$stafflname."\r\n"
							."The leave you requested on ".$leavecreate_dte." for date ".$leaveStartDate." - ".$leaveEndDate." is declined by the coordinator.. \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
					$ok3=mail($to,$subject,$msg1);
					if($ok3){
							$messagess="&nbsp; Sucessfully Rejected Leave and Message Sent!";
							$flagmsg=1;
					}
					else{
							$messagess="&nbsp; Sucessfully Rejected Leave and Message Not Sent!";
							$flagmsg=1;
					}
			}
			else
			{
					$messagess="Something went wrong";
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
  <title>WorkTracker | Admin Panel</title>

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
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
				<h1 class="m-0">Admin Dashboard</h1>
			  </div><!-- /.col -->
			  <div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				  <li class="breadcrumb-item"><a href="#">Home</a></li>
				  <li class="breadcrumb-item active">Dashboard</li>
				</ol>
			  </div><!-- /.col -->
			</div><!-- /.row -->
		  </div><!-- /.container-fluid -->
		</div>
    <!-- /.content-header -->
		
		<?php
		if($ses_level=='Coordinator'){
		?>
				<section class="content">
					<form method="POST">
						<div class="row">
							<div class="col-md-12">
								
								<div class="card card-primary">
									<div class="card-header">
									  <h3 class="card-title">Task Monitoring</h3>

									  <div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
										  <i class="fas fa-minus"></i>
										</button>
									  </div>
									</div>
									<div class="card-body">
										<table class="table table-striped table-hover" id="taskmonitoring">
											<thead>
												  <tr>
													  <th style="width: 1%">
														  #
													  </th>
													  <th style="width: 10%">
														 Submit Date
													  </th>
													  <th style="width: 15%">
														  Project
													  </th>
													  <th style="width: 15%">
														 Task
													  </th>
													  <th style="width: 15%">
														 Sub Task
													  </th>
													  <th style="width: 14%">
														 Assign Date
													  </th>
													  <th style="width: 10%">
														 Target Date
													  </th>
													  <th style="width: 10%">
														 Staff
													  </th>
													  
													  <th style="width: 10%" class="text-center">
														  Process
													  </th>
													 
												  </tr>
											</thead>
											<tbody>
											  <?php
												$no=0;
												$result=mysqli_query($link,"SELECT * FROM staffsubtask_progress_details INNER JOIN assign_subtask ON staffsubtask_progress_details.assigntaskID=assign_subtask.assigntaskID
																														INNER JOIN subtask ON staffsubtask_progress_details.subtaskID=subtask.subtaskID
																														INNER JOIN task ON staffsubtask_progress_details.taskID=task.taskID
																														INNER JOIN project ON staffsubtask_progress_details.projectID =project.projectID
																														INNER JOIN staff ON staffsubtask_progress_details.staffID=staff.empno
																														WHERE staffsubtask_progress_details.approve_status=0");
												while($test = mysqli_fetch_array($result))
												{
													$no++;			
															echo "<tr>";
															echo"<td>" .$no."</td>";
															echo"<td>" .$test['submit_date']."</td>";
															echo"<td>" .$test['projectName']."</td>";
															echo"<td>" .$test['taskName']."</td>";
															echo"<td>" .$test['subtaskName']."</td>";
															echo"<td>" .$test['assign_dte']."</td>";
															echo"<td>" .$test['assigntask_targetdte']."</td>";
															echo"<td>" .$test['firstname']."&nbsp;&nbsp;".$test['lastname']."</td>";
															echo"<td>"; 
															  echo "<a class='btn btn-primary btn-sm' href='daily_report_individual.php?dr=$test[subtaskprogress_ID]' target='_blank'>
																		  <i class='fas fa-folder'>
																		  </i>
																		  Approve
																	</a>";
															echo "</td>";
														
														echo "</tr>";
												}
												
												
												$result3=mysqli_query($link,"SELECT * FROM staffmaintask_progress_details INNER JOIN assign_task ON staffmaintask_progress_details.assignmaintaskID=assign_task.assigntask_id
																														INNER JOIN task ON  staffmaintask_progress_details.maintaskID=task.taskID
																														INNER JOIN project ON staffmaintask_progress_details.projectID =project.projectID
																														INNER JOIN staff ON staffmaintask_progress_details.staffID=staff.empno
																														WHERE staffmaintask_progress_details.maintaskprogress_approve_status=0");
												while($test3 = mysqli_fetch_array($result3))
												{
													$no++;			
															echo "<tr>";
															echo"<td>" .$no."</td>";
															echo"<td>" .$test3['maintaskprogress_submit_date']."</td>";
															echo"<td>" .$test3['projectName']."</td>";
															echo"<td>" .$test3['taskName']."</td>";
															echo"<td></td>";
															echo"<td>" .$test3['taskassign_Date']."</td>";
															echo"<td>" .$test3['taskassign_targerDate']."</td>";
															echo"<td>" .$test3['firstname']."&nbsp;&nbsp;" .$test3['lastname']."</td>";
															echo"<td>"; 
															  echo "<a class='btn btn-primary btn-sm' href='daily_report_individual_task.php?dr=$test3[staffmaintask_progress_details_key]' target='_blank'>
																		  <i class='fas fa-folder'>
																		  </i>
																		  Approve
																	</a>";
															echo "</td>";
														
														echo "</tr>";
												}
												?>
												
											</tbody>
										</table>
									</div>
								  <!-- /.card -->
								</div>
								
								<div class="card card-primary">
									<div class="card-header">
									  <h3 class="card-title">Decline Task Monitoring</h3>

									  <div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
										  <i class="fas fa-minus"></i>
										</button>
									  </div>
									</div>
									<div class="card-body">
										<table class="table table-striped table-hover" id="taskmonitoring">
											<thead>
												  <tr>
													  <th style="width: 1%">
														  #
													  </th>
													 
													  <th style="width: 15%">
														  Project
													  </th>
													  <th style="width: 15%">
														 Task
													  </th>
													  <th style="width: 15%">
														 Sub Task
													  </th>
													  <th style="width: 14%">
														 Assign Date
													  </th>
													  <th style="width: 10%">
														 Target Date
													  </th>
													   <th style="width: 10%">
														 Decline Reason
													  </th>
													  <th style="width: 10">
														 Staff
													  </th>
													  
													  <th style="width: 10%" class="text-center">
														  Process
													  </th>
													 
												  </tr>
											</thead>
											<tbody>
											  <?php
												$no=0;
												$result=mysqli_query($link,"SELECT * FROM assign_subtask INNER JOIN subtask ON assign_subtask.subtaskID=subtask.subtaskID
																										 INNER JOIN task ON assign_subtask.taskID=task.taskID
																										 INNER JOIN project ON assign_subtask.projectID=project.projectID 
																										 INNER JOIN staff ON assign_subtask.staffID=staff.empno
																										WHERE 
																										assign_subtask.complete_status=3
																										AND subtask.subtask_status=0
																										AND task.task_status=0
																										AND project.project_status=0
																										ORDER BY assign_subtask.assigntask_targetdte ASC");
												while($test = mysqli_fetch_array($result))
												{
													$no++;			
															echo "<tr>";
															echo"<td>" .$no."</td>";
															echo"<td>" .$test['projectName']."</td>";
															echo"<td>" .$test['taskName']."</td>";
															echo"<td>" .$test['subtaskName']."</td>";
															echo"<td>" .$test['assign_dte']."</td>";
															echo"<td>" .$test['assigntask_targetdte']."</td>";
															echo"<td>" .$test['decline_reason']."</td>";
															echo"<td>" .$test['firstname']."&nbsp;&nbsp;" .$test['lastname']."</td>";
															echo"<td>"; 
															  echo "<a class='btn btn-primary btn-sm' href='decline_subtask_individual.php?dr=$test[assigntaskID]&ap=1' target='_blank'>
																		  <i class='fas fa-folder'>
																		  </i>
																		  Approve
																	</a>";
																echo "<a class='btn btn-danger btn-sm' href='decline_subtask_individual.php?dr=$test[assigntaskID]&ap=0' target='_blank'>
																		  <i class='fas fa-folder'>
																		  </i>
																		  Reject
																	</a>";
															echo "</td>";
														
														echo "</tr>";
												}
												
												
												$result3=mysqli_query($link,"SELECT * FROM assign_task INNER JOIN task ON assign_task.task_ID=task.taskID
																									   INNER JOIN project ON assign_task.project_id=project.projectID 
																									   INNER JOIN staff ON assign_task.staff_ID=staff.empno
																										WHERE assign_task.taskassign_complete_status=3
																										AND task.task_status=0
																										AND project.project_status=0
																										ORDER BY assign_task.taskassign_targerDate ASC");
												while($test3 = mysqli_fetch_array($result3))
												{
													$no++;			
															echo "<tr>";
															echo"<td>" .$no."</td>";
															echo"<td>" .$test3['projectName']."</td>";
															echo"<td>" .$test3['taskName']."</td>";
															echo"<td></td>";
															echo"<td>" .$test3['taskassign_Date']."</td>";
															echo"<td>" .$test3['taskassign_targerDate']."</td>";
															echo"<td>" .$test3['taskassign_decline_reason']."</td>";
															echo"<td>" .$test3['firstname']."&nbsp;&nbsp;" .$test3['lastname']."</td>";
															echo"<td>"; 
															  echo "<a class='btn btn-primary btn-sm' href='decline_task_individual.php?dr=$test3[assigntask_id]&ap=1' target='_blank'>
																		  <i class='fas fa-folder'>
																		  </i>
																		  Approve
																	</a>";
															   echo "<a class='btn btn-danger btn-sm' href='decline_task_individual.php?dr=$test3[assigntask_id]&ap=0' target='_blank'>
																		  <i class='fas fa-folder'>
																		  </i>
																		  Reject
																	</a>";
															echo "</td>";
														
														echo "</tr>";
												}
												?>
												
											</tbody>
										</table>
									</div>
								  <!-- /.card -->
								</div>
								
								<div class="card card-primary">
									<div class="card-header">
									  <h3 class="card-title">Leave Approvals</h3>

									  <div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
										  <i class="fas fa-minus"></i>
										</button>
									  </div>
									</div>
									<div class="card-body">
										<table class="table table-striped table-hover" id="leaves">
											<thead>
												  <tr>
													  <th style="width: 1%">
														  #
													  </th>
													  <th style="width: 25%">
														  Date of Leaves
													  </th>
													  <th style="width: 15%">
														  Employee Name
													  </th>
													  <th style="width: 25%">
														  Reason
													  </th>
													  <th style="width: 10%">
														  No of Days
													  </th>
													  <th style="width: 14%">
														  Leaves Taken this year
													  </th>
													  <th style="width: 10%" class="text-center" colspan="2">
														  Process
													  </th>
												
												  </tr>
											</thead>
											<tbody>
											  <?php
												$no=0;
												$result5=mysqli_query($link,"SELECT * FROM leaves INNER JOIN staff ON leaves.staffID=staff.empno
																						WHERE leaves.approvelStatus=0");
												while($test5 = mysqli_fetch_array($result5))
												{
													$aa_key="aa_key".$test5['leaveID'];
													$aa_btn="aa_btn".$test5['leaveID'];
													
													$d_key="d_key".$test5['leaveID'];
													$d_btn="d_btn".$test5['leaveID'];
													
													$no++;			
															echo "<tr>";
															echo"<td>" .$no."</td>";
															echo"<td>" .$test5['leaveStartDate']." to " .$test5['leaveEndDate']. "</td>";
															echo"<td>" .$test5['firstname']."&nbsp;&nbsp;" .$test5['lastname']."</td>";
															echo"<td>" .$test5['reason']."</td>";
																$getLeaves="SELECT * FROM leaves WHERE leaves.staffID='$test5[empno]' AND approvelStatus=1";
																$result=mysqli_query($link,$getLeaves);
																$noofleaves=mysqli_num_rows($result);
																
																
																$diff = strtotime($test5['leaveEndDate']) - strtotime($test5['leaveStartDate']);
																//echo "Difference is $diff seconds\n";
																$days = floor($diff/(3600*24));
																
																if($days==0){
																	$days=1;
																}
															
															echo"<td>" .$days."</td>";  
															echo"<td>" .$noofleaves."</td>";
															echo"<td>"; 
															  echo "<input type='hidden' name='".$aa_key."' value='".$test5['leaveID']."' >
																	<input type='submit' value='Approve' name='".$aa_btn."' class='btn btn-success float'>";
															echo "</td>";
															echo"<td>"; 
															  echo "<input type='hidden' name='".$d_key."' value='".$test5['leaveID']."' >
																	<input type='submit' value='Deny' name='".$d_btn."' class='btn btn-danger float'>";
															echo "</td>";
														
														echo "</tr>";
												}
												  
												?>
												
											</tbody>
										</table>
									</div>
								  <!-- /.card -->
								</div>
								
								
								
								
							</div>
						</div>
					</form>
				</section>
		<?php
		}
		if($ses_level=='admin'){
		?>
			<section class="content">
					<form method="POST">
						<div class="row">
							<div class="col-md-12">
								
								<div class="card card-primary">
									<div class="card-header">
									  <h3 class="card-title">Password Reset Request</h3>

									  <div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
										  <i class="fas fa-minus"></i>
										</button>
									  </div>
									</div>
									<div class="card-body">
										<table class="table table-striped table-hover" id="taskmonitoring">
											<thead>
												  <tr>
													  <th style="width: 1%">
														  #
													  </th>
													  <th style="width: 20%">
														 Staff ID
													  </th>
													  <th style="width: 20%">
														  First Name
													  </th>
													  <th style="width: 20%">
														  Last Name
													  </th>
													  <th style="width: 20%">
														 User Name
													  </th>
													 
													  <th style="width: 19%" class="text-center">
														  Process
													  </th>
													 
												  </tr>
											</thead>
											<tbody>
											  <?php
												$no=0;
												$result=mysqli_query($link,"SELECT * FROM staff WHERE resetpawrequest_status=1");
												while($test = mysqli_fetch_array($result))
												{
													$no++;			
															echo "<tr>";
															echo"<td>" .$no."</td>";
															echo"<td>" .$test['staff_id']."</td>";
															echo"<td>" .$test['firstname']."</td>";
															echo"<td>" .$test['lastname']."</td>";
															echo"<td>" .$test['user_name']."</td>";
															echo"<td>"; 
															  echo "<a class='btn btn-primary btn-sm' href='staffprofile.php?ids=$test[empno]' target='_blank'>
																		  <i class='fas fa-folder'>
																		  </i>
																		  Approve
																	</a>";
															echo "</td>";
														
														echo "</tr>";
												}
												?>
												
											</tbody>
										</table>
									</div>
								  <!-- /.card -->
								</div>
								
								
								
								  <!-- /.card -->
							</div>
						</div>
					
					</form>
			</section>
		
		<?php
		}
		?>
	</div>



           
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
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
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
<script>
  $(function () {
    $("#taskmonitoring").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
  $(function () {
    $("#leaves").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
</body>
</html>
