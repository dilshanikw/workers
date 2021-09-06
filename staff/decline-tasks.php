<?php
include("connect.php");
include("session.php");
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

    <!-- Main content -->
		<section class="content">
			<form method="POST">
				<div class="row">
					<div class="col-md-12">
						
						<div class="card card-primary">
							<div class="card-header">
							  <h3 class="card-title">Ongoing Task & Sub Task</h3>

							  <div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
								  <i class="fas fa-minus"></i>
								</button>
							  </div>
							</div>
							<div class="card-body">
								<table class="table table-striped table-hover" id="projects">
									<thead>
										<tr>
											  <th style="width: 1%">
												  #
											  </th>
											  <th style="width: 5%">
												  Date 
											  </th>
											  <th style="width: 18%">
												  Project
											  </th>
											  <th style="width: 18%">
												  Task
											  </th>
											  <th style="width: 18%">
												  Sub Task
											  </th>
											  <th style="width: 15%">
												  Sub Task Description
											  </th>
											  <th style="width: 10%">
												  Target Date
											  </th>
											  <th style="width: 15%" class="text-center">
												  Process
											  </th>
											 
										</tr>
									</thead>
									<tbody>
									  <?php
										$no=0;
										$result7=mysqli_query($link,"SELECT * FROM assign_subtask INNER JOIN subtask ON assign_subtask.subtaskID=subtask.subtaskID
																								 INNER JOIN task ON assign_subtask.taskID=task.taskID
																								 INNER JOIN project ON assign_subtask.projectID=project.projectID 
																								 INNER JOIN staff ON assign_subtask.staffID=staff.empno
																								WHERE assign_subtask.staffID='$ses_ukey'
																								AND assign_subtask.complete_status=0
																								AND subtask.subtask_status=0
																								AND task.task_status=0
																								AND project.project_status=0
																								ORDER BY assign_subtask.assigntask_targetdte ASC");
										while($test = mysqli_fetch_array($result7))
										{
											$no++;			
													echo "<tr>";
													echo"<td>" .$no."</td>";
													echo"<td>" .$test['assign_dte']."<br><small>" .$test['assigntask_createdte']. "</small></td>";
													echo"<td>" .$test['projectName']."</td>";
													echo"<td>" .$test['taskName']."</td>";
													echo"<td>" .$test['subtaskName']."</td>";
													echo"<td>" .$test['subtaskDesc']."</td>";
													echo"<td>" .$test['assigntask_targetdte']."</td>";
													echo"<td>"; 
														echo " <a class='btn btn-danger btn-sm' href='decline_subtask_process.php?as=$test[assigntaskID]' target='_blank'>
														  <i class='fas fa-paper-plane'>
														  </i>
														 Decline Task
														</a>";
													echo "</td>";
												
												echo "</tr>";
										}
										
										$result8=mysqli_query($link,"SELECT * FROM assign_task INNER JOIN task ON assign_task.task_ID=task.taskID
																							   INNER JOIN project ON assign_task.project_id=project.projectID 
																							   INNER JOIN staff ON assign_task.staff_ID=staff.empno
																								WHERE assign_task.staff_ID='$ses_ukey'
																								AND assign_task.taskassign_complete_status=0
																								AND task.task_status=0
																								AND project.project_status=0
																								ORDER BY assign_task.taskassign_targerDate ASC");
										while($test = mysqli_fetch_array($result8))
										{
											$no++;			
													echo "<tr>";
													echo"<td>" .$no."</td>";
													echo"<td>" .$test['taskassign_Date']."<br><small>" .$test['taskassign_createdte']. "</small></td>";
													echo"<td>" .$test['projectName']."</td>";
													echo"<td>" .$test['taskName']."</td>";
													echo"<td></td>";
													echo"<td></td>";
													echo"<td>" .$test['taskassign_targerDate']."</td>";
													echo"<td>"; 
														echo " <a class='btn btn-danger btn-sm' href='decline_task_process.php?as=$test[assigntask_id]' target='_blank'>
														  <i class='fas fa-paper-plane'>
														  </i>
														Decline Task
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
						
						
						
						
						
						
						
						
					</div>
				</div>
			</form>
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
