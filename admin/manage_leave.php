<?php
include 'connect.php';
include 'session.php';
error_reporting(0);
?>

<?php
	$result2=mysqli_query($link,"SELECT * FROM leaves INNER JOIN staff ON leaves.staffID=staff.empno
																WHERE leaves.approvelStatus=0");
	while($test2 = mysqli_fetch_array($result2))
	{
			$aa_key1="aa_key".$test2['leaveID'];
			$aa_btn1="aa_btn".$test2['leaveID'];
			$dd_btn1="dd_btn".$test2['leaveID'];
			
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
		if(isset($_POST[$dd_btn1])){
			$query2 = "UPDATE leaves SET approvelStatus=2 WHERE leaveID='$_POST[$aa_key1]'";
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
  <title>WorkTracker | Leave Management</title>

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
            <h1 class="m-0">Leave Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Leave Management</li>
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
              <h3 class="card-title">Manage Leaves</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
				<form method="POST" name="f1">
					<table class="table table-striped table-hover" id="projects">
						<thead>
							  <tr>
								  <th style="width: 1%">
									  #
								  </th>
								  <th style="width: 10%">
									  Date of Leaves
								  </th>
								  <th style="width: 20%">
									  Employee Name
								  </th>
								  <th style="width: 10%" class="text-center">
									  Approve
								  </th>
								  <th style="width: 10%" class="text-center">
									  Deny
								  </th>
							  </tr>
						</thead>
						<tbody>
						  <?php
							$no=0;
							$result=mysqli_query($link,"SELECT * FROM leaves INNER JOIN staff ON leaves.staffID=staff.empno
																	WHERE leaves.approvelStatus=0");
							while($test = mysqli_fetch_array($result))
							{
								$aa_key="aa_key".$test['leaveID'];
								$aa_btn="aa_btn".$test['leaveID'];
								$dd_btn="dd_btn".$test['leaveID'];
								$no++;			
										echo "<tr>";
										echo"<td>" .$no."</td>";
										echo"<td>" .$test['leaveStartDate']." to " .$test['leaveEndDate']. "</td>";
										echo"<td>" .$test['firstname']."" .$test['lastname']."</td>";
										echo"<td align='center'>"; 
										echo "<input type='hidden' name='".$aa_key."' value='".$test['leaveID']."' >
												<input type='submit' value='Approve Leaves' name='".$aa_btn."' class='btn btn-success float'>";
										echo "</td>";
										echo"<td align='center'>"; 
												echo "<input type='submit' value='Deny' name='".$dd_btn."' class='btn btn-danger float'>";
										echo "</td>";
									echo "</tr>";
							}
							  
							?>
							
						</tbody>
					</table>
				</form>  
			</div>
          <!-- /.card -->
        </div>
		
		
		
		<div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"> Leaves History</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
			<form method="POST" name="f2">	
				<div class="form-group">
							<label for="taskName">Staff Member</label>
							<select name="assign_person" class="form-control" required onchange="this.form.submit()">
								<?php
																
									$sql13="SELECT * FROM staff ORDER BY firstname ASC";
									$result13=mysqli_query($link,$sql13);
									$option13 ="";
									while($row13=mysqli_fetch_array($result13)){
										$option13 = $option13."<option value=$row13[empno]>$row13[firstname] $row13[lastname]</option>";		
									}
									
									if(isset($_POST['assign_person'])){
										
										$sql2="SELECT * FROM staff WHERE empno='$_POST[assign_person]'";
										$result2=mysqli_query($link,$sql2);
										$option2 ="";
										while($row2=mysqli_fetch_array($result2)){
											$option2 = $option2."<option value=$row2[empno]>$row2[firstname] $row2[lastname]</option>";		
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
				</div>
				
				
				<table class="table table-striped table-hover" id="projects">
					<thead>
						  <tr>
							  <th style="width: 1%">
								  #
							  </th>
							  <th style="width: 10%">
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
							  <th style="width: 10%">
								  Total Leaves Taken
							  </th>
						  </tr>
					</thead>
					<tbody>
					  <?php
						$no1=0;
						$result3=mysqli_query($link,"SELECT * FROM leaves INNER JOIN staff ON leaves.staffID=staff.empno
																WHERE leaves.staffID='$_POST[assign_person]'
																AND leaves.approvelStatus=1");
						while($test3 = mysqli_fetch_array($result3))
						{
							$no1++;
									echo "<tr>";
									echo"<td>" .$no1."</td>";
									echo"<td>" .$test3['leaveStartDate']." to " .$test3['leaveEndDate']. "</td>";
									echo"<td>" .$test3['firstname']."" .$test3['lastname']."</td>";
									echo"<td>" .$test3['reason']."</td>";
										$getLeaves="SELECT * FROM leaves WHERE leaves.staffID='$_POST[assign_person]' AND approvelStatus=1";
										$result=mysqli_query($link,$getLeaves);
										$noofleaves=mysqli_num_rows($result);
										
										
										$diff = strtotime($test3['leaveEndDate']) - strtotime($test3['leaveStartDate']);
										$days = floor($diff/(3600*24));
										$acday=$days+1;
									
									echo"<td>" .$acday."</td>";  
									echo"<td>" .$noofleaves."</td>";
									
								echo "</tr>";
						}
						  
						?>
					</tbody>
				</table>
			</form>
			</div>
          <!-- /.card -->
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
    $("#projects").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
</body>
</html>
