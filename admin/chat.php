<?php
include 'connect.php';
include 'session.php';
?>


<?php

if(isset($_POST['send']))
{
	

	$reciver = $_POST['reciver'];
	$msg = $_POST['msg'];

	
		if($msg==null){
			
		}
		else{
			$query = "INSERT INTO `chat` (`chatID`, 
											`sender_id`, 
											`senderuserlevel`, 
											`receiverID`, 
											`receiver_userlevel`, 
											`message`) 
											VALUES (NULL, 
											'$ses_ukey', 
											'$ses_level', 
											'$reciver', 
											'Staff',
											'$msg'
											);";
				if(mysqli_query($link,$query))
				{
					$messagess="&nbsp; Sucessfully Send Message!";
					$flagmsg=1;
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
  <title>WorkTracker | Chat</title>

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
            <h1 class="m-0">Chat</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Chat</li>
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
              <h3 class="card-title">Chat</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
				<div class="form-group">
						<label>Select Receiver</label>
               
							<select class="form-control" name="reciver" id="reciver" style="width: 100%;" onchange="this.form.submit()">
								<?php
																
									$que2="SELECT * FROM staff ORDER BY empno ASC";
									$rslt2=mysqli_query($link,$que2);
									$opt2 ="";
									while($row2=mysqli_fetch_array($rslt2)){
										$opt2 = $opt2."<option value=$row2[empno]>$row2[firstname] $row2[lastname]</option>";	//Load Staff
									}
																
									if(isset($_POST['reciver'])){
											$que3="SELECT * FROM staff WHERE empno='$_POST[reciver]'";
											$rslt3=mysqli_query($link,$que3);
											$opt3 ="";
											while($row3=mysqli_fetch_array($rslt3)){
												$opt3 = $opt3."<option value=$row3[empno]>$row3[firstname] $row3[lastname]</option>";	//Load Staff
											}
											echo $opt3;
											echo $opt2;
									}
									else{
										echo "<option value='' disabled selected hidden>Select Receiver</option>";
										echo $opt2;
									}
																
								?>

							</select>
				</div>
				<table width="100%">
				<?php
				if(isset($_POST['reciver'])){
					$que4="SELECT DISTINCT(sent_dte) AS disdateofmsg FROM chat WHERE (senderuserlevel='Coordinator' AND receiverID='$_POST[reciver]') OR (sender_id='$_POST[reciver]' AND receiver_userlevel='Coordinator') ORDER BY chatID ASC";
					$rslt4=mysqli_query($link,$que4);
					while($row4=mysqli_fetch_array($rslt4)){
				?>
						<?php
						$que6="SELECT * FROM chat WHERE senderuserlevel='Coordinator' AND receiverID='$_POST[reciver]' AND sent_dte='$row4[disdateofmsg]'";
						$rslt6=mysqli_query($link,$que6);
						if(mysqli_num_rows($rslt6)==0){
						?>
							<?php
							$que7="SELECT * FROM chat WHERE sender_id='$_POST[reciver]' AND receiver_userlevel='Coordinator' AND sent_dte='$row4[disdateofmsg]'";
							$rslt7=mysqli_query($link,$que7);
							$queryinfo7=mysqli_fetch_assoc($rslt7);
								$que9="SELECT * FROM staff WHERE empno='$_POST[reciver]'";
								$rslt9=mysqli_query($link,$que9);
								$queryinfo9=mysqli_fetch_assoc($rslt9);
							?>
							<tr>
								<td width="50%">
									<label ><?php echo $queryinfo9['firstname']." ".$queryinfo9['lastname']; ?></label>
									<br>
									<label ><?php echo $queryinfo7['message']; ?></label>
									<br>
									<label ><?php echo $row4['disdateofmsg']; ?></label>
									<br>
									<br>
								</td>
								<td width="50%">
									
								</td>
							</tr>
						<?php
						}
						else{
						?>
							<?php
							$que8="SELECT * FROM chat WHERE senderuserlevel='Coordinator' AND receiverID='$_POST[reciver]' AND sent_dte='$row4[disdateofmsg]'";
							$rslt8=mysqli_query($link,$que8);
							$queryinfo8=mysqli_fetch_assoc($rslt8);	
							?>
							<tr>
								<td width="50%"></td>
								<td width="50%">
									<label >You</label>
									<br>
									<label ><?php echo $queryinfo8['message']; ?></label>
									<br>
									<label ><?php echo $row4['disdateofmsg']; ?></label>
									<br>
								</td>
							</tr>
						<?php
						}
						?>
				<?php
					}
				}
				?>
				</table>
				<br>
				<br>
				<div class="form-group">
					<label for="projectDesc">Message</label>
					<textarea class="form-control" name="msg" id="msg" placeholder="Type your Message Here"></textarea>
				</div>
			  	
            <!-- /.card-body -->
			    <div class="row">
					<div class="col-12">
					  
					  <input type="submit" value="Send" name="send" class="btn btn-success float">
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
