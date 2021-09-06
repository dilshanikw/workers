<?php
include 'connect.php';
include 'session.php';

$cur_dte=date("Y-m-d");

$query ="SELECT * from project WHERE projectID='$_GET[ids]'";
$result=mysqli_query($link,$query);
$queryinfo=mysqli_fetch_assoc($result);	

$projectName=$queryinfo['projectName'];
$projectDesc=$queryinfo['projectDesc'];
$startDate=$queryinfo['startDate'];
$client=$queryinfo['client'];
$CreateDate=$queryinfo['CreateDate'];


	#Get name of coordinator who created the project
	$CreateBy=$queryinfo['CreateBy'];
		$sql2="SELECT * FROM coordinator WHERE codinator_key='$CreateBy'";
		$result2=mysqli_query($link,$sql2);
		$cordinator=mysqli_fetch_assoc($result2);
		
		$cod_first = $cordinator['first_name'];
		$cod_last = $cordinator['lastname'];
		$cod_full = $cod_first." ".$cod_last;
	

	#Get name of responsible Person
	$resperson=$queryinfo['responsiblePerson'];
		$sql="SELECT * FROM staff WHERE empno='$resperson'";
		$result1=mysqli_query($link,$sql);
		$info=mysqli_fetch_assoc($result1);
		
		$user_first=$info['firstname'];
		$user_last=$info['lastname'];
		$user_full=$user_first." ".$user_last;
	
	#project status display
	$pro_status=$queryinfo['project_status'];
	$targetDate=$queryinfo['targetDate'];
	$complete_dte=$queryinfo['complete_dte'];
	$cancelled_date=$queryinfo['cancelled_date'];
	
		if($pro_status==0){
			$status = '<span class="badge bg-info">On-Going</span>';
			$date="Target End Date: " .$targetDate;
		}
		else if($pro_status==1){
			$status = '<span class="badge bg-success">Completed</span>';
			$date="Completed Date: " .$complete_dte ;
		}
		else{
			$status = '<span class="badge bg-danger">Cancelled</span>';
			$date="Cancelled Date: " .$cancelled_date;
		}
		

		
	if(isset($_POST['submit_complete'])){
		$query1 = "UPDATE project SET project_status=1,complete_dte='$cur_dte' WHERE projectID='$_GET[ids]'";
		if(mysqli_query($link,$query1)){
			
			$query2 = "UPDATE task SET task_status=1,endDate='$cur_dte' WHERE projectID='$_GET[ids]'";
			mysqli_query($link,$query2);
			
			$query3 = "UPDATE subtask SET subtask_status=1,subtaskendDate='$cur_dte' WHERE  projectID='$_GET[ids]'";
			mysqli_query($link,$query3);
			
			$query4 = "UPDATE assign_subtask SET complete_status=1 WHERE  projectID='$_GET[ids]'";
			mysqli_query($link,$query4);
			
			$query5 = "UPDATE staffsubtask_progress_details SET approve_status=1 WHERE  projectID='$_GET[ids]'";
			mysqli_query($link,$query5);
			
			$messagess="&nbsp; Sucessfully Complete Projects!";
			$flagmsg=1;
		}
		
	}
	
	if(isset($_POST['submit_cancel'])){
		
		$query1 = "UPDATE project SET project_status=2,cancelled_date='$cur_dte' WHERE projectID='$_GET[ids]'";
		if(mysqli_query($link,$query1)){
			
			$query2 = "UPDATE task SET task_status=2 WHERE projectID='$_GET[ids]'";
			mysqli_query($link,$query2);
			
			$query3 = "UPDATE subtask SET subtask_status=2 WHERE  projectID='$_GET[ids]'";
			mysqli_query($link,$query3);
			
			$query4 = "UPDATE assign_subtask SET complete_status=2 WHERE  projectID='$_GET[ids]'";
			mysqli_query($link,$query4);
			
			$query5 = "UPDATE staffsubtask_progress_details SET approve_status=2 WHERE  projectID='$_GET[ids]'";
			mysqli_query($link,$query5);
			
			$messagess="&nbsp; Sucessfully Cancel Projects!";
			$flagmsg=1;
		}
		
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Projects</title>

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
            <h1 class="m-0">Project Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item"><a href="viewprojects.php">Project</a></li>
              <li class="breadcrumb-item active">Project Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><span class="text-muted">Project Name: </span><?php echo $projectName ?></h3>

        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
              <div class="row">
                
				<a href="view_proj_task.php?pr=<?php echo $_GET['ids']; ?>">
					<div class="col-12 col-sm-4">
					  <div class="info-box bg-<?php echo $utheme?>">
						<a href="view_proj_task.php?pr=<?php echo $_GET['ids']; ?>">
							<div class="info-box-content">
							  <span class="info-box-text text-center text-muted">No. of Tasks</span>
							  <?php
								$sql3="SELECT * FROM task WHERE projectID='$_GET[ids]'";
								$result3=mysqli_query($link,$sql3);
								$nooftsk=mysqli_num_rows($result3);
							  ?>
							  <span class="info-box-number text-center text-muted mb-0"><?php echo $nooftsk; ?></span>
							</div>
						</a>
					  </div>
					</div>
                
				
				
					<div class="col-12 col-sm-4">
					  <div class="info-box bg-<?php echo $utheme?>">
						<a href="view_proj_subtask.php?pr=<?php echo $_GET['ids']; ?>">
							<div class="info-box-content">
							   <?php
								$sql4="SELECT * FROM subtask WHERE projectID='$_GET[ids]'";
								$result4=mysqli_query($link,$sql4);
								$noofsubtsk=mysqli_num_rows($result4);
							  ?>
							  <span class="info-box-text text-center text-muted">No. of Sub Tasks</span>
							  <span class="info-box-number text-center text-muted mb-0"><?php echo $noofsubtsk; ?></span>
							</div>
						</a>
					  </div>
					</div>
				
				
				
				
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-<?php echo $utheme?>">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Responsible Person</span>
                      <span class="info-box-number text-center text-muted mb-0"><?php echo $user_full ?></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h4>Project Description</h4>
                    <div class="post clearfix">
                      <p class="text-muted"><?php echo $projectDesc ?></p>
					</div>
					<div class="post">
					<?php
					if($pro_status==0){
					?>
						<h5 class="mt-5 text-muted">Project Actions</h5>
						
						<div class="row">
							<form name="f1" method="post">
								<div class="col-3">
									<input type="submit" value="Complete" name="submit_complete" class="btn btn-success float">
								</div>
							</form>
							<div class="col-3">
								<a href="upd_project.php?pcd=<?php echo $_GET['ids'];?>"><button  class="btn btn-info float">Update</button></a>
							</div>
							<form name="f2" method="post">
								<div class="col-3">
									<input type="submit" value="Cancel" name="submit_cancel" class="btn btn-danger float">
								</div>
							</form>
							
						</div>
						</form>
					<?php
					}
					?>
					</div>
              <div class="text-center mt-5 mb-3">
                
              </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
              <h4>Details</h4>
			  <div class="text-muted">
                <p class="text-lg-4">Project Status
                  <b class="d-block"><?php echo $status ?><br><small><?php echo $date ?></small></b>
                </p>
				<p class="text-sm">Client Company
                  <b class="d-block"><?php echo $client ?></b>
                </p>
				<p class="text-sm">Start Date
                  <b class="d-block"><?php echo $startDate ?></b>
                </p>
				<p class="text-sm">Created By
                  <b class="d-block"><?php echo $cod_full ?></b>
                </p>
                <p class="text-sm">Create Date
                  <b class="d-block"><?php echo $CreateDate ?></b>
                </p>
              </div>

              
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
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
    $("#projects").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
</body>
</html>
