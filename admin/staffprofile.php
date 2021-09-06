<?php
include("connect.php");
include("session.php");
	
$query11 ="SELECT * from staff WHERE empno='$_GET[ids]'";
$result11=mysqli_query($link,$query11);
$queryinfo11=mysqli_fetch_assoc($result11);	
	
	$staff_id=$queryinfo11['staff_id'];
	
	$first_name=$queryinfo11['firstname'];
	$last_name=$queryinfo11['lastname'];
	$full_name=$first_name." ".$last_name;
	
	$designation='Staff Member';
	
	$add1=$queryinfo11['address1'];
	$add2=$queryinfo11['address2'];
	$add3=$queryinfo11['address3'];
	$scity=$queryinfo11['city'];
	$location=$add1." ,<br>".$add2.", ".$add3." <br>".$scity;
	
	$contact=$queryinfo11['contact_no'];
	$semail=$queryinfo11['email'];
	$sappointdate=$queryinfo11['appointment_date'];
	$sjob_description=$queryinfo11['job_description'];
	$squalifications=$queryinfo11['qualifications'];
	$sprofile_pic=$queryinfo11['profile_pic'];
	
	$screate_dte=$queryinfo11['create_dte'];
	$screate_by=$queryinfo11['create_by'];
	
	
	if(isset($_POST['resetpassword'])){
		$maxpprifix_staff = sprintf('%04d',$_GET['ids']);	
		$reste_staff=MD5($maxpprifix_staff);
		
		$query1 = "UPDATE `staff` SET  password='$reste_staff',resetpawrequest_status=NULL WHERE empno='$_GET[ids]'";
		if(mysqli_query($link,$query1)){
					
					$to=$semail;
						
						
						$subject="Password Reset";				//subject eka danna
						$msg1="Dear  ".$first_name." ".$last_name."\r\n"
							."You have requested to reset the password. Your new password is ".$maxpprifix_staff.". Use the new password to login. \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							$messagess="&nbsp; Sucessfully Reset Password and Message Sent!";
							$flagmsg=1;
						}
						else{
							$messagess="&nbsp; Sucessfully Reset Password and Message Not Sent!";
							$flagmsg=1;
						}
			
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Staff Profile</title>

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

  <!-- Navbar -->
	<?php include("topnavi.php");?>

  <!-- Main Sidebar Container -->
	<?php include("leftnavi.php");?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Staff Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item"><a href="viewusers.php">Manage User Accounts</a></li>
			  <li class="breadcrumb-item active"><?php echo $full_name ?>'s Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="../staff/emp_images/<?php echo $sprofile_pic;?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $full_name; ?></h3>

				<p class="text-muted text-center"><?php echo $designation; ?>
				<br>StaffID: <?php echo $staff_id; ?></p>

				<?php
		
						$noofprj=0;
						
						$sql9="SELECT DISTINCT(project.projectID) AS disproid FROM project INNER JOIN assign_task ON project.projectID=assign_task.project_id																							WHERE project.project_status=1
															AND assign_task.staff_ID='$_GET[ids]'";
						$result9=mysqli_query($link,$sql9);
						while($test1 = mysqli_fetch_array($result9))
						{
							$noofprj++;
						}
						
						$sql10="SELECT * FROM assign_task WHERE staff_ID='$_GET[ids]' AND taskassign_complete_status=1";
						$result10=mysqli_query($link,$sql10);
						$nooftsk=mysqli_num_rows($result10);
				?>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Projects Completed</b> <a class="float-right"><?php echo $noofprj;?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Tasks Completed</b> <a class="float-right"><?php echo $nooftsk; ?></a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i>Qualifications</strong>

                <p class="text-muted">
                  <?php echo $squalifications ?>
                </p>

				<hr>

                <strong><i class="fas fa-phone mr-1"></i> Contact Number</strong>

                <p class="text-muted"><?php echo $contact ?></p>
				
				<hr>

                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                <p class="text-muted"><?php echo $semail ?></p>
				
                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted"><?php echo $location ?></p>


              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
				  <li class="nav-item"><a class="nav-link" href="#jobdesc" data-toggle="tab">Job Description</a></li>
                  <li class="nav-item"><a class="nav-link" href="#message" data-toggle="tab">Message</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
					<!-- Active tab -->
					<div class="active tab-pane" id="activity">
						<form name="f2" method="post">
							<input type="submit" name="resetpassword" value="Reset Password" class="btn btn-danger">
						</form>

					</div>
                  <!-- Qualifications tab -->
					<div class="tab-pane" id="jobdesc">
						<form name="jobdesc" method="post">
						  <div class="row">
							<div class="col-md-12">
							  <div class="card card-primary">
								

								<p class="text-muted"><?php echo $sjob_description ?></p>
								
								<!-- /.card-body -->
							  </div>
							  <!-- /.card -->
							</div>
						  </div>
						</form>

					</div>
					<!-- Message tab -->
					<div class="tab-pane" id="message">
						<form class="form-horizontal">
						  <div class="form-group row">
							<label for="receiver" class="col-sm-2 col-form-label">Select Receiver</label>
							
							<select class="form-control" name="projectddd" id="projectID" style="width: 100%;">
								<?php
																
									$que="SELECT * FROM staff ORDER BY empno ASC";
									$rslt=mysqli_query($link,$que);
									$opt ="";
									while($row=mysqli_fetch_array($rslt)){
										$opt = $opt."<option value=$row[empno]>$row[firstname] $row[lastname]</option>";	//Load Staff
									}
																
																
									echo "<option value='' disabled selected hidden>Select Receiver</option>";
									echo $opt;
																
								?>

							</select>
						  </div>
						  <div class="form-group row">
							<label for="msg" class="col-sm-2 col-form-label">Message</label><br>
							<div class="col-sm-12">
							  <textarea class="form-control" id="msg" placeholder="Type your Message Here"></textarea>
							</div>
						  </div>
						  <div class="form-group row">
							<div class="col-sm-10">
							  <button type="submit" class="btn btn-success">Send</button>
							</div>
						  </div>
						</form>
					</div>
                  <!-- /.tab-pane -->
					
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
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
var password = document.getElementById("password")
  , confirmpassword = document.getElementById("confirmpassword");

function validatePassword(){
  if(password.value != confirmpassword.value) {
    confirmpassword.setCustomValidity("Passwords Don't Match");
  } else {
    confirmpassword.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirmpassword.onkeyup = validatePassword;
</script>
</body>
</html>

