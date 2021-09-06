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
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="reminder.php">
          <i class="far fa-comments"></i>
		  <?php
			$noofreminders=0;
			$sql970=mysqli_query($link,"SELECT * FROM assign_task INNER JOIN task ON assign_task.task_ID=task.taskID
														WHERE assign_task.staff_ID='$ses_ukey'
														AND assign_task.taskassign_complete_status=0 
														AND assign_task.taskassign_targerDate>='$cur_dte' 
														AND assign_task.taskassign_targerDate<='$duedate'");
			$reminder970=mysqli_num_rows($sql970);
			$noofreminders+=$reminder970;
			
			$sql968=mysqli_query($link,"SELECT * FROM assign_subtask INNER JOIN subtask ON assign_subtask.subtaskID=subtask.subtaskID
														WHERE assign_subtask.staffID='$ses_ukey'
														AND assign_subtask.complete_status=0 
														AND assign_subtask.assigntask_targetdte>='$cur_dte' 
														AND assign_subtask.assigntask_targetdte<='$duedate'");
			$reminder968=mysqli_num_rows($sql968);
			$noofreminders+=$reminder968;
		  ?>
          <span class="badge badge-danger navbar-badge"><?php echo $noofreminders; ?></span>
        </a>
        
		<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?php echo $noofreminders; ?> Reminders</span>
		<?php
			$sql971=mysqli_query($link,"SELECT * FROM assign_task INNER JOIN task ON assign_task.task_ID=task.taskID
														WHERE assign_task.staff_ID='$ses_ukey'
														AND assign_task.taskassign_complete_status=0 
														AND assign_task.taskassign_targerDate>='$cur_dte' 
														AND assign_task.taskassign_targerDate<='$duedate'");
			while($test15 = mysqli_fetch_array($sql971)){
					
					$to=$uemail;
						
						
						$subject=" REMINDER: Your task ".$test15['taskName']." is overdue on ".$test15['taskassign_targerDate']."";				//subject eka danna
						$msg1="Dear  ".$uadmin_first." ".$uadmin_last."\r\n"
							." The Due date for task ".$test15['taskName']." is on ".$test15['taskassign_targerDate'].".\r\n"
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
				<i class="fas fa-envelope mr-2 text-sm"></i> Your <?php echo $test15['taskName']; ?> is overdue on <?php echo $test15['taskassign_targerDate']; ?>
 
				<span class="float-right text-muted text-sm"><?php echo $cur_dte; ?></span>
			  </a>
			  
			  
		<?php
			}
		?>
		
		<?php
			$sql969=mysqli_query($link,"SELECT * FROM assign_subtask INNER JOIN subtask ON assign_subtask.subtaskID=subtask.subtaskID
														WHERE assign_subtask.staffID='$ses_ukey'
														AND assign_subtask.complete_status=0 
														AND assign_subtask.assigntask_targetdte>='$cur_dte' 
														AND assign_subtask.assigntask_targetdte<='$duedate'");
			while($test16 = mysqli_fetch_array($sql969)){
						
						$to=$uemail;
						$subject=" REMINDER: Your sub task ".$test16['subtaskName']." is overdue on ".$test16['assigntask_targetdte']."";				//subject eka danna
						$msg1="Dear  ".$uadmin_first." ".$uadmin_last."\r\n"
							." The Due date for task ".$test16['subtaskName']." is on ".$test16['assigntask_targetdte'].".\r\n"
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
				<i class="fas fa-envelope mr-2 text-sm"></i> Your <?php echo $test16['subtaskName']; ?> is overdue on <?php echo $test16['assigntask_targetdte']; ?>
 
				<span class="float-right text-muted text-sm"><?php echo $cur_dte; ?></span>
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
		$sql998=mysqli_query($link,"SELECT * FROM  project WHERE responsiblePerson='$ses_ukey' AND project_status=0 AND CreateDate LIKE '$cur_dte%'");
		$nofication998=mysqli_num_rows($sql998);
		$noofnotification+=$nofication998;
		
		$sql996=mysqli_query($link,"SELECT * FROM  assign_task WHERE staff_ID='$ses_ukey' AND taskassign_complete_status=0 AND taskassign_createdte LIKE '$cur_dte%'");
		$nofication996=mysqli_num_rows($sql996);
		$noofnotification+=$nofication996;
		
		$sql994=mysqli_query($link,"SELECT * FROM  assign_subtask WHERE staffID='$ses_ukey' AND complete_status=0 AND assigntask_createdte LIKE '$cur_dte%'");
		$nofication994=mysqli_num_rows($sql994);
		$noofnotification+=$nofication994;
		
		$sql992=mysqli_query($link,"SELECT * FROM leaves WHERE staffID='$ses_ukey' AND approvelStatus=1 AND leavecreate_dte>='$agoddate' AND leavecreate_dte<='$afteddate'");
		$nofication992=mysqli_num_rows($sql992);
		$noofnotification+=$nofication992;
		
		$sql990=mysqli_query($link,"SELECT * FROM leaves WHERE staffID='$ses_ukey' AND approvelStatus=2 AND leavecreate_dte>='$agoddate' AND leavecreate_dte<='$afteddate'");
		$nofication990=mysqli_num_rows($sql990);
		$noofnotification+=$nofication990;
		
		$sql988=mysqli_query($link,"SELECT * FROM staffsubtask_progress_details WHERE staffID='$ses_ukey' AND approve_status=1 AND submit_date>='$agoddate' AND submit_date<='$afteddate'");
		$nofication988=mysqli_num_rows($sql988);
		$noofnotification+=$nofication988;
		
		$sql986=mysqli_query($link,"SELECT * FROM staffsubtask_progress_details WHERE staffID='$ses_ukey' AND approve_status=2 AND submit_date>='$agoddate' AND submit_date<='$afteddate'");
		$nofication986=mysqli_num_rows($sql986);
		$noofnotification+=$nofication986;
		
		$sql984=mysqli_query($link,"SELECT * FROM staffmaintask_progress_details WHERE staffID='$ses_ukey' AND maintaskprogress_approve_status=1 AND maintaskprogress_submit_date>='$agoddate' AND maintaskprogress_submit_date<='$afteddate'");
		$nofication984=mysqli_num_rows($sql984);
		$noofnotification+=$nofication984;
		
		$sql982=mysqli_query($link,"SELECT * FROM staffmaintask_progress_details WHERE staffID='$ses_ukey' AND maintaskprogress_approve_status=2 AND maintaskprogress_submit_date>='$agoddate' AND maintaskprogress_submit_date<='$afteddate'");
		$nofication982=mysqli_num_rows($sql982);
		$noofnotification+=$nofication982;
		
		$sql980=mysqli_query($link,"SELECT * FROM assign_subtask WHERE staffID='$ses_ukey' 
																	AND decline_reason IS NOT NULL 
																	AND complete_status=2 
																	AND assigntask_createdte>='$agoddate' 
																	AND assigntask_createdte<='$afteddate'");
		$nofication980=mysqli_num_rows($sql980);
		$noofnotification+=$nofication980;
		
		$sql978=mysqli_query($link,"SELECT * FROM assign_task WHERE staff_ID='$ses_ukey' 
																	AND taskassign_decline_reason IS NOT NULL 
																	AND taskassign_complete_status=2 
																	AND taskassign_createdte>='$agoddate' 
																	AND taskassign_createdte<='$afteddate'");
		$nofication978=mysqli_num_rows($sql978);
		$noofnotification+=$nofication978;
		
		$sql976=mysqli_query($link,"SELECT * FROM assign_subtask WHERE staffID='$ses_ukey' 
																	AND decline_reason IS NOT NULL 
																	AND complete_status=0 
																	AND assigntask_createdte>='$agoddate' 
																	AND assigntask_createdte<='$afteddate'");
		
		$nofication976=mysqli_num_rows($sql976);
		$noofnotification+=$nofication976;
		
		$sql974=mysqli_query($link,"SELECT * FROM assign_task WHERE staff_ID='$ses_ukey' 
																	AND taskassign_decline_reason IS NOT NULL 
																	AND taskassign_complete_status=0 
																	AND taskassign_createdte>='$agoddate' 
																	AND taskassign_createdte<='$afteddate'");
		$nofication974=mysqli_num_rows($sql974);
		$noofnotification+=$nofication974;
		
		$sql972=mysqli_query($link,"SELECT * FROM project INNER JOIN assign_task ON project.projectID=assign_task.project_id
											WHERE assign_task.staff_ID='$ses_ukey' AND project.cancelled_date='$cur_dte'");
		$nofication972=mysqli_num_rows($sql972);
		$noofnotification+=$nofication972;
		?>
        <a class="nav-link" data-toggle="dropdown" href="notification.php">
			<i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><?php echo $noofnotification; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?php echo $noofnotification; ?> Notifications</span>
          
		  <?php
		   $sql999=mysqli_query($link,"SELECT * FROM  project WHERE responsiblePerson='$ses_ukey' AND project_status=0 AND CreateDate LIKE '$cur_dte%'");
		   while($test = mysqli_fetch_array($sql999)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> You are the team leader for the project <?php echo $test['projectName']; ?>
				<span class="float-right text-muted text-sm"><?php echo $test['CreateDate']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		  
		  <?php
		   $sql997=mysqli_query($link,"SELECT * FROM  assign_task WHERE staff_ID='$ses_ukey' AND taskassign_complete_status=0 AND taskassign_createdte LIKE '$cur_dte%'");
		   while($test1 = mysqli_fetch_array($sql997)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> A new task is assigned
				<span class="float-right text-muted text-sm"><?php echo $test1['taskassign_createdte']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		  
		  <?php
		   $sql995=mysqli_query($link,"SELECT * FROM  assign_subtask WHERE staffID='$ses_ukey' AND complete_status=0 AND assigntask_createdte LIKE '$cur_dte%'");
		   while($test2 = mysqli_fetch_array($sql995)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> A new sub task is assigned
				<span class="float-right text-muted text-sm"><?php echo $test2['assigntask_createdte']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		  <?php
		   $sql993=mysqli_query($link,"SELECT * FROM leaves WHERE staffID='$ses_ukey' AND approvelStatus=1 AND leavecreate_dte>='$agoddate' AND leavecreate_dte<='$afteddate'");
		   while($test3 = mysqli_fetch_array($sql993)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> The leave requested is approved 
				<span class="float-right text-muted text-sm"><?php echo $test3['leavecreate_dte']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		  <?php
		   $sql991=mysqli_query($link,"SELECT * FROM leaves WHERE staffID='$ses_ukey' AND approvelStatus=2 AND leavecreate_dte>='$agoddate' AND leavecreate_dte<='$afteddate'");
		   while($test4 = mysqli_fetch_array($sql991)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> The leave requested is declined 
				<span class="float-right text-muted text-sm"><?php echo $test4['leavecreate_dte']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		  <?php
		   $sql989=mysqli_query($link,"SELECT * FROM staffsubtask_progress_details INNER JOIN subtask ON staffsubtask_progress_details.subtaskID=subtask.subtaskID
												WHERE staffsubtask_progress_details.staffID='$ses_ukey' 
												AND staffsubtask_progress_details.approve_status=1 
												AND staffsubtask_progress_details.submit_date>='$agoddate' 
												AND staffsubtask_progress_details.submit_date<='$afteddate'");
		   while($test5 = mysqli_fetch_array($sql989)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> The daily report for <?php echo $test5['subtaskName'];?> is approved 
				<span class="float-right text-muted text-sm"><?php echo $test5['submit_date']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		   <?php
		   $sql987=mysqli_query($link,"SELECT * FROM staffsubtask_progress_details INNER JOIN subtask ON staffsubtask_progress_details.subtaskID=subtask.subtaskID
												WHERE staffsubtask_progress_details.staffID='$ses_ukey' 
												AND staffsubtask_progress_details.approve_status=2 
												AND staffsubtask_progress_details.submit_date>='$agoddate' 
												AND staffsubtask_progress_details.submit_date<='$afteddate'");
		   while($test6 = mysqli_fetch_array($sql987)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> The daily report for <?php echo $test6['subtaskName'];?> is declined 
				<span class="float-right text-muted text-sm"><?php echo $test6['submit_date']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		  
		   <?php
		   $sql985=mysqli_query($link,"SELECT * FROM staffmaintask_progress_details INNER JOIN task ON staffmaintask_progress_details.maintaskID=task.taskID
												WHERE staffmaintask_progress_details.staffID='$ses_ukey' 
												AND staffmaintask_progress_details.maintaskprogress_approve_status=1 
												AND staffmaintask_progress_details.maintaskprogress_submit_date>='$agoddate' 
												AND staffmaintask_progress_details.maintaskprogress_submit_date<='$afteddate'");
		   while($test7 = mysqli_fetch_array($sql985)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> The daily report for <?php echo $test7['taskName'];?> is Approved 
				<span class="float-right text-muted text-sm"><?php echo $test7['maintaskprogress_submit_date']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		  
		  <?php
		   $sql983=mysqli_query($link,"SELECT * FROM staffmaintask_progress_details INNER JOIN task ON staffmaintask_progress_details.maintaskID=task.taskID
												WHERE staffmaintask_progress_details.staffID='$ses_ukey' 
												AND staffmaintask_progress_details.maintaskprogress_approve_status=2 
												AND staffmaintask_progress_details.maintaskprogress_submit_date>='$agoddate' 
												AND staffmaintask_progress_details.maintaskprogress_submit_date<='$afteddate'");
		   while($test8 = mysqli_fetch_array($sql983)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> The daily report for <?php echo $test8['taskName'];?> is declined 
				<span class="float-right text-muted text-sm"><?php echo $test8['maintaskprogress_submit_date']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		  <?php
		   $sql981=mysqli_query($link,"SELECT * FROM assign_subtask WHERE staffID='$ses_ukey' 
																	AND decline_reason IS NOT NULL 
																	AND complete_status=2 
																	AND assigntask_createdte>='$agoddate' 
																	AND assigntask_createdte<='$afteddate'");
		   while($test9 = mysqli_fetch_array($sql981)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> Your Sub Task rejection is approved  
				<span class="float-right text-muted text-sm"><?php echo $test9['assigntask_createdte']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		  
		  <?php
		   $sql979=mysqli_query($link,"SELECT * FROM assign_task WHERE staff_ID='$ses_ukey' 
																	AND taskassign_decline_reason IS NOT NULL 
																	AND taskassign_complete_status=2 
																	AND taskassign_createdte>='$agoddate' 
																	AND taskassign_createdte<='$afteddate'");
		   while($test10 = mysqli_fetch_array($sql979)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> Your Task rejection is approved  
				<span class="float-right text-muted text-sm"><?php echo $test10['taskassign_createdte']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		   <?php
		   $sql977=mysqli_query($link,"SELECT * FROM assign_subtask WHERE staffID='$ses_ukey' 
																	AND decline_reason IS NOT NULL 
																	AND complete_status=0 
																	AND assigntask_createdte>='$agoddate' 
																	AND assigntask_createdte<='$afteddate'");
		   while($test11 = mysqli_fetch_array($sql977)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> Your Sub Task rejection is rejected  
				<span class="float-right text-muted text-sm"><?php echo $test11['assigntask_createdte']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		  
		   <?php
		   $sql975=mysqli_query($link,"SELECT * FROM assign_task WHERE staff_ID='$ses_ukey' 
																	AND taskassign_decline_reason IS NOT NULL 
																	AND taskassign_complete_status=0
																	AND taskassign_createdte>='$agoddate' 
																	AND taskassign_createdte<='$afteddate'");
		   while($test12 = mysqli_fetch_array($sql975)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> Your Task rejection is rejected  
				<span class="float-right text-muted text-sm"><?php echo $test12['taskassign_createdte']; ?></span>
			  </a>
		  <?php
		  }
		  ?>
		   
		   <?php
		   $sql973=mysqli_query($link,"SELECT * FROM project INNER JOIN assign_task ON project.projectID=assign_task.project_id
											WHERE assign_task.staff_ID='$ses_ukey' AND project.cancelled_date='$cur_dte'");
		   while($test13 = mysqli_fetch_array($sql973)){
		  ?>
			  <div class="dropdown-divider"></div>
			  <a href="notification.php" class="dropdown-item">
				<i class="fas fa-envelope mr-2 text-sm"></i> The <?php echo $test13['projectName'] ?> project is Cancelled  
				<span class="float-right text-muted text-sm"><?php echo $test13['cancelled_date']; ?></span>
			  </a>
		  <?php
		  }
		  ?>

		 <div class="dropdown-divider"></div>
          <a href="notification.php" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="logout.php" role="button">
          <i class="fas fa-sign-out-alt"></i>Sign Out
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->