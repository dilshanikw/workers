<?php
include 'connect.php';
include 'session.php';

$cur_dte=date("Y-m-d");
?>


<?php
	if(isset($_GET['pcd'])){
		
		$query3 ="SELECT * FROM project WHERE projectID='$_GET[pcd]'";
		$result3=mysqli_query($link,$query3);
		$queryinfo3=mysqli_fetch_assoc($result3);

				$a1=$queryinfo3['projectID'];
				$a2=$queryinfo3['projectName'];
				$a3=$queryinfo3['projectDesc'];
				$a4=$queryinfo3['startDate'];
				$a5=$queryinfo3['targetDate'];
				$a6=$queryinfo3['client'];
				$a7=$queryinfo3['responsiblePerson'];
				
		
		
		if(isset($_POST['submit']))
		{
			

			$projectName = $_POST['projectName'];
			$projectDesc = $_POST['projectDesc'];
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
			$client = $_POST['client'];
			$responsiblePerson=$_POST['responsible'];

			
			
				
				$query3 = "SELECT * FROM project WHERE responsiblePerson='$responsiblePerson'";
				$result3=mysqli_query($link,$query3);
				$noofproresponsibleperson=mysqli_num_rows($result3);
				
				if($noofproresponsibleperson<=5){
					$query = "UPDATE project SET projectName='$projectName', 
												 projectDesc='$projectDesc', 
													startDate='$startDate',
													targetDate='$endDate', 
													client='$client', 
													responsiblePerson='$responsiblePerson' 
											WHERE projectID='$_GET[pcd]'";
						if(mysqli_query($link,$query))
						{
							$messagess="&nbsp; Sucessfully Change Project!";
							$flagmsg=1;
						}
						else
						{
							$messagess="Something went wrong";
							$flagmsg=0;
						}
				}
				else{
					$messagess="&nbsp; Sorry This Person Cannot Take Any More Projects";
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
  <title>WorkTracker | Update Projects</title>

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
  
  <script>
	function checkDate() {
	   var selectedText = document.getElementById('startDate').value;
	   var selectedDate = new Date(selectedText);
	   var now = new Date();
	   if (selectedDate < now) {
		alert("Date must be in the future");
	   }
	}
  </script>
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
            <h1 class="m-0">Update Project</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Project</li>
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
              <h3 class="card-title">Update Project</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
			  <div class="form-group">
				
                <label for="projectName">Project Name</label>
                <input type="text" id="projectName" name="projectName" class="form-control" required value="<?php echo $a2; ?>">
              </div>
              <div class="form-group">
                <label for="projectDesc">Project Description</label>
                <textarea id="projectDesc" name="projectDesc" class="form-control" rows="4"><?php echo $a3; ?></textarea>
              </div>
			  	<!-- Start Date -->
				<div class="form-group">
                  <label>Start Date:</label>
                  
                        <input type="date" name="startDate" id="startDate" class="form-control" onchange="checkDate()" value="<?php echo $a4; ?>">
					
				</div>
				<!--End Date -->
				<div class="form-group">
                  <label>Traget Date:</label>
                   
                        <input type="date" name="endDate" class="form-control" data-target="#endDate" value="<?php echo $a5; ?>"/>
					
				</div>
              <div class="form-group">
                <label for="client">Client Company</label>
                <input type="text" id="client" name="client" class="form-control" value="<?php echo $a6; ?>">
              </div>
              <div class="form-group">
                <label for="responsiblePerson">Responsible Person</label>
                <select name="responsible" class="form-control" required>
					<?php
													
						$sql13="SELECT * FROM staff ORDER BY firstname ASC";
						$result13=mysqli_query($link,$sql13);
						$option13 ="";
						while($row13=mysqli_fetch_array($result13)){
							$option13 = $option13."<option value=$row13[empno]>$row13[firstname] $row13[lastname]</option>";			
						}
						
						$sql14="SELECT * FROM staff WHERE empno='$a7' ORDER BY firstname ASC";
						$result14=mysqli_query($link,$sql14);
						$option14 ="";
						while($row14=mysqli_fetch_array($result14)){
							$option14 = $option14."<option value=$row14[empno]>$row14[firstname] $row14[lastname]</option>";			
						}
													
													
						echo $option14;
						echo $option13;
													
					?>
				</select>
              </div>

            <!-- /.card-body -->
			    <div class="row">
					<div class="col-12">
					  
					  <input type="submit" value="Update Project" name="submit" class="btn btn-success float">
					</div>
				</div>
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
  position: 'middle',
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
