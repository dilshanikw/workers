<?php
$cur_dte=date("Y-m-d");
$cur_dte_start=$cur_dte." 00:00:00";
$cur_dte_end=$cur_dte." 24:00:00";




$agoddate= date('Y-m-d', strtotime('today - 14 days'));
$afteddate= date('Y-m-d', strtotime('today + 14 days'));


$cur_dte_agoodte=$agoddate;
$cur_dte_afterdte=$afteddate;

$duedate= date('Y-m-d', strtotime('today + 2 days'));
$duedate1= date('Y-m-d', strtotime('today - 2 days'));
?>


<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-<?php echo $utheme?>">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </ul>
	
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
	 <?php
	if($ses_level=='Coordinator'){
	?>
	  
			  <li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="reminder.php">
				  <i class="far fa-comments"></i>
				  <?php
					$noofreminders=0;
					$sql970=mysqli_query($link,"SELECT * FROM leaves INNER JOIN staff ON leaves.staffID=staff.empno
													WHERE leaves.approvelStatus=0");
					$reminder970=mysqli_num_rows($sql970);
					$noofreminders+=$reminder970;
					
					
					$sql968=mysqli_query($link,"SELECT * FROM  staffmaintask_progress_details INNER JOIN task ON staffmaintask_progress_details.maintaskID=task.taskID
															WHERE staffmaintask_progress_details.maintaskprogress_approve_status=0");
					$reminder968=mysqli_num_rows($sql968);
					$noofreminders+=$reminder968;
					
					$sql966=mysqli_query($link,"SELECT * FROM  staffsubtask_progress_details INNER JOIN subtask ON staffsubtask_progress_details.subtaskID=subtask.subtaskID
															WHERE staffsubtask_progress_details.approve_status=0");
					$reminder966=mysqli_num_rows($sql966);
					$noofreminders+=$reminder966;
					
					$sql964=mysqli_query($link,"SELECT * FROM  project WHERE project_status=0 AND targetDate>='$cur_dte' AND targetDate<='$duedate'");
					$reminder964=mysqli_num_rows($sql964);
					$noofreminders+=$reminder964;
				  ?>
				  <span class="badge badge-danger navbar-badge"><?php echo $noofreminders; ?></span>
				</a>
				
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				  <span class="dropdown-item dropdown-header"><?php echo $noofreminders; ?> Reminders</span>
				<?php
					$sql971=mysqli_query($link,"SELECT * FROM leaves INNER JOIN staff ON leaves.staffID=staff.empno
													WHERE leaves.approvelStatus=0");
					while($test17 = mysqli_fetch_array($sql971)){
						
						$to=$uemail;
						$subject=" REMINDER: You have unattended leave requests";				//subject eka danna
						$msg1="Dear Coordinator\r\n"
							." You have unattended leave requests from ".$test17['firstname']."  ".$test17['lastname']." for ".$test17['leaveStartDate'].".\r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						
				?>
					  <div class="dropdown-divider"></div>
					  <a href="reminder.php" class="dropdown-item">
						<i class="fas fa-envelope mr-2 text-sm"></i> <?php echo $test17['namewithinitials']; ?> is waiting for leave request approval.

		 
						<span class="float-right text-muted text-sm"><?php echo $cur_dte; ?></span>
					  </a>
				<?php
					}
				?>
				
				<?php
					$sql969=mysqli_query($link,"SELECT * FROM  staffmaintask_progress_details INNER JOIN task ON staffmaintask_progress_details.maintaskID=task.taskID
											WHERE staffmaintask_progress_details.maintaskprogress_approve_status=0");
					while($test18 = mysqli_fetch_array($sql969)){
						
						$sql963=mysqli_query($link,"SELECT * FROM staff WHERE empno='$test18[staffID]'");
						while($test21 = mysqli_fetch_array($sql963)){
							$empssnme=$test21['firstname']." ".$test21['lastname'];
						}
						
						$to=$uemail;
						$subject=" REMINDER: The ".$test18['taskName']." daily report is waiting for your feedback.";				//subject eka danna
						$msg1="Dear Coordinator\r\n"
							." The task ".$test18['taskName']." sent by ".$empssnme." on ".$test18['maintaskprogress_submit_date']." is waiting for your feedback..\r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						
				?>
					  <div class="dropdown-divider"></div>
					  <a href="reminder.php" class="dropdown-item">
						<i class="fas fa-envelope mr-2 text-sm"></i> The <?php echo $test18['taskName']; ?> progress report is waiting for your feedback.


		 
						<span class="float-right text-muted text-sm"><?php echo $test18['maintaskprogress_submit_date']; ?></span>
					  </a>
				<?php
					}
				?>
				
				<?php
					$sql967=mysqli_query($link,"SELECT * FROM  staffsubtask_progress_details INNER JOIN subtask ON staffsubtask_progress_details.subtaskID=subtask.subtaskID
											WHERE staffsubtask_progress_details.approve_status=0");
					while($test19 = mysqli_fetch_array($sql967)){
						
						$sql963=mysqli_query($link,"SELECT * FROM staff WHERE empno='$test19[staffID]'");
						while($test21 = mysqli_fetch_array($sql963)){
							$empssnme=$test21['firstname']." ".$test21['lastname'];
						}
						
						$to=$uemail;
						$subject=" REMINDER: The ".$test19['subtaskName']." daily report is waiting for your feedback.";				//subject eka danna
						$msg1="Dear Coordinator\r\n"
							." The subtask ".$test19['subtaskName']." sent by ".$empssnme." on ".$test19['submit_date']." is waiting for your feedback..\r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							
						}
						else{
							
						}
				?>
					  <div class="dropdown-divider"></div>
					  <a href="reminder.php" class="dropdown-item">
						<i class="fas fa-envelope mr-2 text-sm"></i> The <?php echo $test19['subtaskName']; ?> progress report is waiting for your feedback.


		 
						<span class="float-right text-muted text-sm"><?php echo $test19['submit_date']; ?></span>
					  </a>
				<?php
					}
				?>
				

				<?php
					$sql965=mysqli_query($link,"SELECT * FROM  project WHERE project_status=0 AND targetDate>='$cur_dte' AND targetDate<='$duedate'");
					while($test20 = mysqli_fetch_array($sql965)){
				?>
					  <div class="dropdown-divider"></div>
					  <a href="reminder.php" class="dropdown-item">
						<i class="fas fa-envelope mr-2 text-sm"></i> Your <?php echo $test20['projectName']; ?> Project is Overdue on <?php echo $test20['targetDate']; ?>.


		 
						<span class="float-right text-muted text-sm"><?php echo $test20['targetDate']; ?></span>
					  </a>
				<?php
					}
				?>
				  <div class="dropdown-divider"></div>
				  <a href="reminder.php" class="dropdown-item dropdown-footer">See All Reminders</a>
				</div>
			  </li>
			  
			  
			  <!-- Notifications Dropdown Menu -->
			  <li class="nav-item dropdown">
				<?php
				$noofnotification=0;
				
				$sql998=mysqli_query($link,"SELECT * FROM  staffmaintask_progress_details WHERE maintaskprogress_approve_status=0");
				$nofication998=mysqli_num_rows($sql998);
				$noofnotification+=$nofication998;
				
				$sql996=mysqli_query($link,"SELECT * FROM  staffsubtask_progress_details WHERE approve_status=0");
				$nofication996=mysqli_num_rows($sql996);
				$noofnotification+=$nofication996;
				
				$sql994=mysqli_query($link,"SELECT * FROM leaves WHERE approvelStatus=0");
				$nofication994=mysqli_num_rows($sql994);
				$noofnotification+=$nofication994;
				
				?>
				<a class="nav-link" data-toggle="dropdown" href="notification.php">
				  <i class="far fa-bell"></i>
				  <span class="badge badge-warning navbar-badge"><?php echo $noofnotification; ?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				  <span class="dropdown-item dropdown-header"><?php echo $noofnotification; ?> Notifications</span>
				  <div class="dropdown-divider"></div>
				  
				  <?php
				  $sql999=mysqli_query($link,"SELECT * FROM  staffmaintask_progress_details INNER JOIN staff ON staffmaintask_progress_details.staffID=staff.empno
											WHERE maintaskprogress_approve_status=0");
				  while($test1 = mysqli_fetch_array($sql999)){
				  ?>
					  <div class="dropdown-divider"></div>
					  <a href="notification.php" class="dropdown-item">
						<i class="fas fa-envelope mr-2 text-sm"></i> A progress report has been submitted by <?php echo $test1['namewithinitials']; ?>
						<span class="float-right text-muted text-sm"><?php echo $test1['maintaskprogress_createdte']; ?></span>
					  </a>
				  <?php
				  }
				  ?>
				  
				  <?php
				  $sql997=mysqli_query($link,"SELECT * FROM  staffsubtask_progress_details INNER JOIN staff ON staffsubtask_progress_details.staffID=staff.empno
											WHERE approve_status=0");
				  while($test2 = mysqli_fetch_array($sql997)){
				  ?>
					  <div class="dropdown-divider"></div>
					  <a href="notification.php" class="dropdown-item">
						<i class="fas fa-envelope mr-2 text-sm"></i> A progress report has been submitted by <?php echo $test2['namewithinitials']; ?>
						<span class="float-right text-muted text-sm"><?php echo $test2['staffsubtaskprogress_createdte']; ?></span>
					  </a>
				  <?php
				  }
				  ?>
				  
				 <?php
				  $sql995=mysqli_query($link,"SELECT * FROM leaves INNER JOIN staff ON leaves.staffID=staff.empno
											WHERE approvelStatus=0");
				  while($test3 = mysqli_fetch_array($sql995)){
				  ?>
					  <div class="dropdown-divider"></div>
					  <a href="notification.php" class="dropdown-item">
						<i class="fas fa-envelope mr-2 text-sm"></i><?php echo $test3['namewithinitials']; ?> has sent a leave request.
						<span class="float-right text-muted text-sm"><?php echo $test3['leavecreate_dte']; ?></span>
					  </a>
				  <?php
				  }
				  ?>
				  <a href="notification.php" class="dropdown-item dropdown-footer">See All Notifications</a>
				</div>
			  </li>
	<?php
	}
	?>
	  <li class="nav-item">
        <a class="nav-link" href="logout.php" role="button">
          <i class="fas fa-sign-out-alt"></i>Sign Out
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->