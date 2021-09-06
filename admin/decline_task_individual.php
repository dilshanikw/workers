<?php
include 'connect.php';
include 'session.php';

if(isset($_GET['dr']) && isset($_GET['ap'])){
	
	$query3 ="SELECT *,
				 project.startDate AS prostartdte,
				 project.targetDate AS protragetdte,
				 task.startDate AS taskstartdte,
				 task.targetDate AS tasktragetdte
					FROM staffmaintask_progress_details INNER JOIN assign_task  ON staffmaintask_progress_details.assignmaintaskID=assign_task.assigntask_id
													    INNER JOIN task ON staffmaintask_progress_details.maintaskID=task.taskID
													    INNER JOIN project ON staffmaintask_progress_details.projectID =project.projectID
													    INNER JOIN staff ON staffmaintask_progress_details.staffID=staff.empno
													WHERE staffmaintask_progress_details.staffmaintask_progress_details_key='$_GET[dr]'";
	$result3=mysqli_query($link,$query3);
	$queryinfo3=mysqli_fetch_assoc($result3);

	 $proj_id=$queryinfo3['projectID'];
	 $proj_nme=$queryinfo3['projectName'];
	 $proj_des=$queryinfo3['projectDesc'];
	 $proj_start=$queryinfo3['prostartdte'];
	 $proj_traget=$queryinfo3['protragetdte'];
	 $proj_client=$queryinfo3['client'];
	 $proj_resperson=$queryinfo3['responsiblePerson'];
	 
	 
	 $task_nme=$queryinfo3['taskName'];
	 $task_description=$queryinfo3['taskDescription'];
	 $task_start=$queryinfo3['taskstartdte'];
	 $task_traget=$queryinfo3['tasktragetdte'];
	 
	
	 $assigntask_id=$queryinfo3['assigntask_id'];
	 $assigntask_tragetdte=$queryinfo3['taskassign_targerDate'];
	 $assigntask_completepresenrage=$queryinfo3['taskassign_complete_presentage'];
	 $assigntask_description=$queryinfo3['maintaskprogress_description'];
	 $assigntask_individualpresentage=$queryinfo3['maintaskprogress_progress'];
	 $assigntask_submit=$queryinfo3['maintaskprogress_submit_date'];
	 $assigntask_empname=$queryinfo3['firstname']." ".$queryinfo3['lastname'];
	 $assigntask_empmail=$queryinfo3['email'];
	 $assigntask_empfnme=$queryinfo3['firstname'];
	 $assigntask_emplnme=$queryinfo3['lastname'];
	 
	 
	 
	 $assigntask_taskkid=$queryinfo3['taskID'];
	 $assigntask_projjid=$queryinfo3['projectID'];
	 
	 
	$query2 ="SELECT *
				FROM staff WHERE empno='$proj_resperson'";
	$result2=mysqli_query($link,$query2);
	$queryinfo2=mysqli_fetch_assoc($result2);
		 $proj_respersonnme=$queryinfo2['firstname']." ".$queryinfo2['lastname'];
	
	
	if($_GET['ap']==1){
			$query2 = "UPDATE assign_task SET taskassign_complete_status=2 WHERE assigntask_id='$_GET[dr]'";
			if(mysqli_query($link,$query2))
			{
					$to=$assigntask_empmail;
						
						$subject="Your Task rejection is accepted".$task_nme."";				//subject eka danna
						$msg1="Dear  ".$assigntask_empname."\r\n"
							."The daily report for the ".$task_nme." rejection request is accepted by the coordinator. \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
								echo "<script>
									alert('Successfully Approval Decline this Task and Message Sent!.');
									window.location.href='home.php';
								</script>";
						}
						else{
								echo "<script>
									alert('Successfully Approval Decline this Task and Message Not Sent!.');
									window.location.href='home.php';
								</script>";
							
						}

				
			}
			else
			{
					echo "<script>
							alert('Something Went Worng.');
							window.location.href='home.php';
						</script>";
			}
	}
	if($_GET['ap']==0){
			$query2 = "UPDATE assign_task SET taskassign_complete_status=0 WHERE assigntask_id='$_GET[dr]'";
			if(mysqli_query($link,$query2))
			{
						$to=$assigntask_empmail;
						
						$subject="Your Task rejection is rejected ".$task_nme."";				//subject eka danna
						$msg1="Dear  ".$assigntask_empname."\r\n"
							."Your Subtask ".$task_nme." rejection request is rejected by the coordinator. \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							
							echo "<script>
								alert('Successfully Reject Decline this Task and Message Sent!.');
								window.location.href='home.php';
							</script>";
						}
						else{
							
							echo "<script>
								alert('Successfully Reject Decline this Task and Message Not Sent!.');
								window.location.href='home.php';
							</script>";
						}		
			}
			else
			{
					echo "<script>
							alert('Something Went Worng.');
							window.location.href='home.php';
						</script>";
			}
		
	}
	
}
?>
