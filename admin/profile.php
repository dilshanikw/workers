<?php
include("connect.php");
include("session.php");

if(isset($_POST['changepass']))
{
	echo "<script>				
			window.location.href='home.php';
		</script>";
}


if(isset($_POST['changepass']))
{	
	$current_pass =$_POST['currentpassword'];
	$pass =$_POST['password'];
	$confirm_pass =$_POST['confirmpassword'];
	
	$spass = MD5($pass);
	$scurrentpass = MD5($current_pass);
	
	if($scurrentpass==$upass){
		if($pass==$confirm_pass){
		
			$query1 = "UPDATE coordinator SET password='$spass' WHERE codinator_key='$ses_ukey'";
			if(mysqli_query($link,$query1)){
				
			$messagess="&nbsp;  Password Changed Sucessfully";
			$flagmsg=1;
			}
			else{
				$messagess="&nbsp;  Something went wrong";
				$flagmsg=0;
			}
		}
		else{
			$messagess="&nbsp;  New password and Confirm password do not Match!";
			$flagmsg=0;
		}			
	}
	else{
		$messagess="&nbsp; Current Password Did not Match";
		$flagmsg=0;	
	}

}
?>
<?php
		
if(isset($_POST['changetheme'])){
	if($utheme=='dark-mode'){
		$chgtheme1 = "UPDATE `coordinator` SET `theme` = 'light-mode' WHERE `codinator_key` = '$ses_ukey'";

				if(mysqli_query($link,$chgtheme1)){
					$messagess="&nbsp;  Theme changed sucessfully!";
					$flagmsg=1;
					echo "<script>				
						window.location.href='profile.php';
					</script>";
				}
				else{
					$messagess="&nbsp;  Something went wrong";
					$flagmsg=0;
				}
	}
	else{
		$chgtheme2 = "UPDATE coordinator SET theme='dark-mode' WHERE codinator_key='$ses_ukey'";
				if(mysqli_query($link,$chgtheme2)){
					$messagess="&nbsp;  Theme changed sucessfully!";
					$flagmsg=1;
					echo "<script>				
						window.location.href='profile.php';
					</script>";
				}
				else{
					$messagess="&nbsp;  Something went wrong";
					$flagmsg=0;
				}
	}
}

$target_dir = "emp_images/";

if(isset($_POST['changeprofile'])){
	
		
            // File upload path
            $target_file = $target_dir.basename($_FILES['upd_images']['name']);

            // Check whether file type is valid
            $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
				
				
				$target_new = $target_dir ."prof".$ses_ukey.".".$fileType;
				if (file_exists($target_new)) {
							
						chmod($target_new,0755); //Change the file permissions if allowed
						unlink($target_new); //remove the file
						
						move_uploaded_file($_FILES["upd_images"]["tmp_name"], $target_new);
						$awers1="prof".$ses_ukey.".".$fileType;
						$sql42="UPDATE coordinator SET profile_pic='$awers1' WHERE codinator_key='$ses_ukey'";
						if(mysqli_query($link,$sql42)){
							echo "<script>
									alert('Sucessfully Change Profile Picture.');
										
								</script>";
						}
						else{
							echo "<script>
									alert('Execute Error.');
										
								</script>";
						}
						
				}
				else{
						// Upload file to server
						move_uploaded_file($_FILES["upd_images"]["tmp_name"], $target_new);
						$awers1="prof".$ses_ukey.".".$fileType;
									$sql42="UPDATE coordinator SET profile_pic='$awers1' WHERE codinator_key='$ses_ukey'";
									if(mysqli_query($link,$sql42)){
										echo "<script>
											alert('Sucessfully Change Profile Picture.');
										
										</script>";
									}
									else{
										echo "<script>
											alert('Execute Error.');
										
										</script>";
									}
				}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WorkTracker | Profile</title>

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
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
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
                       src="emp_images/<?php echo $uprofilepic;?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $uadmin_fulln; ?></h3>

                <p class="text-muted text-center"><?php echo $ses_level ?></p>

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

                <strong><i class="fas fa-phone mr-1"></i> Contact Number</strong>

                <p class="text-muted"><?php echo $ucontact ?></p>
				
				<hr>

                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                <p class="text-muted"><?php echo $uemail ?></p>
				
                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted"><?php echo $ucity ?></p>


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
				  <li class="nav-item"><a class="nav-link" href="#changepassword" data-toggle="tab">Change Password</a></li>
				  <li class="nav-item"><a class="nav-link" href="#changeprofileimage" data-toggle="tab">Change Profile Image</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
					<form name="chgtheme" method="post" class="form-horizontal">
						<div class="form-group row">
							<div class="col-sm-10">
								<input type="submit" name="changetheme" value="Change Theme" class="btn btn-info">
							</div>
						</div>
					</form>


                  </div>
                  <!-- /.tab-pane -->

                  <!-- Message tab -->
					<div class="tab-pane" id="message">
						
					</div>
                  <!-- /.tab-pane -->
                  <!-- /.tab-pane -->
				  <div class="tab-pane" id="changepassword">
					<form name="chgpass" method="post">
					  <div class="row">
						<div class="col-md-12">
						  <div class="card card-primary">
							<div class="card-header">
							  <h3 class="card-title">Reset Password</h3>

							</div>
							<div class="card-body">
									<div align="center"><label >User Name: <?php echo $ses_user; ?></label></div>
									

									<div class="form-group">
										<label for="currentpassword">Current Password *</label>
										<input type="password" id="currentpassword" name="currentpassword" class="form-control">
									</div>

									<div class="form-group">
										<label for="password">Password *</label>
										<input type="password" id="password" name="password" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{3,}">
									</div>
									<div class="form-group">
										<label for="confirmpassword">Confirm Password *</label>
										<input type="password" id="confirmpassword" name="confirmpassword" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{3,}">
									</div>
									<div class="row">
										<div class="col-12">
										  <input type="submit" value="Reset Password" name="changepass" class="btn btn-success float">
										</div>
									</div>
							</div>
							<!-- /.card-body -->
						  </div>
						  <!-- /.card -->
						</div>
					  </div>
					</form>

                  </div>
				  
				  <div class="tab-pane" id="changeprofileimage">
					<form name="chgprofile" method="post" enctype="multipart/form-data">
					  <div class="row">
						<div class="col-md-12">
						  <div class="card card-primary">
							<div class="card-header">
							  <h3 class="card-title">Change Profile Image</h3>

							</div>
							<div class="card-body">
									<div class="form-group">
										<label>Images :</label>   
										<input type="file" class="form-control input-sm" name="upd_images">
									</div>
									<div class="row">
										<div class="col-12">
										  <input type="submit" value="Change Profile Picture" name="changeprofile" class="btn btn-success float">
										</div>
									</div>
							</div>
							<!-- /.card-body -->
						  </div>
						  <!-- /.card -->
						</div>
					  </div>
					</form>

                  </div>
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
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
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

$("input[data-bootstrap-switch]").each(function(){
  $(this).bootstrapSwitch('state', $(this).prop('checked'));
})
	
</script>
</body>
</html>

