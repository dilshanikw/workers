<?php
include 'connect.php';
include 'session.php';

if(isset($_GET['dr']) && isset($_GET['ap'])){
	
	$query3 ="SELECT * FROM assign_task INNER JOIN task ON assign_task.task_ID=task.taskID
										INNER JOIN project ON assign_task.project_id=project.projectID 
										INNER JOIN staff ON assign_task.staff_ID=staff.empno
										WHERE assign_task.taskassign_complete_status=3
										AND assign_task.assigntask_id='$_GET[dr]'
										AND task.task_status=0
										AND project.project_status=0";
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
	 
	 $subtask_nme=$queryinfo3['subtaskName'];
	 $subtask_description=$queryinfo3['subtaskDesc'];
	 $subtask_start=$queryinfo3['subtaskstartDate'];
	 $subtask_traget=$queryinfo3['subtasktargetDate'];
	 
	 $assignsubtask_id=$queryinfo3['assigntaskID'];
	 $assignsubtask_tragetdte=$queryinfo3['assigntask_targetdte'];
	 $assignsubtask_completepresenrage=$queryinfo3['complete_presentage'];
	 $assignsubtask_description=$queryinfo3['description'];
	 $assignsubtask_individualpresentage=$queryinfo3['presentage'];
	 $assignsubtask_submit=$queryinfo3['submit_date'];
	 $assignsubtask_empname=$queryinfo3['firstname']." ".$queryinfo3['lastname'];
	 $assignsubtask_empmail=$queryinfo3['email'];
	 $assignsubtask_empfnme=$queryinfo3['firstname'];
	 $assignsubtask_emplnme=$queryinfo3['lastname'];
	 
	 
	 $assignsubtask_subtaskkid=$queryinfo3['subtaskID'];
	 $assignsubtask_taskkid=$queryinfo3['taskID'];
	 $assignsubtask_projjid=$queryinfo3['projectID'];
	 
	 
	$query2 ="SELECT *
			FROM staff WHERE empno='$proj_resperson'";
	$result2=mysqli_query($link,$query2);
	$queryinfo2=mysqli_fetch_assoc($result2);
	 $proj_respersonnme=$queryinfo2['firstname']." ".$queryinfo2['lastname'];
	
	
	if($_GET['ap']==1){
			$query2 = "UPDATE assign_subtask SET complete_status=2 WHERE assigntaskID='$_GET[dr]'";
			if(mysqli_query($link,$query2))
			{
						$to=$assignsubtask_empmail;
						
						
						$subject="Your SubTask rejection is accepted".$subtask_nme."";				//subject eka danna
						$msg1="Dear  ".$assignsubtask_empname."\r\n"
							."The daily report for the ".$subtask_nme." rejection request is accepted by the coordinator. \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							
							echo "<script>
								alert('Successfully Approval Decline this Sub Task and Message Sent!.');
								window.location.href='home.php';
							</script>";
						}
						else{
							
							echo "<script>
								alert('Successfully Approval Decline this Sub Task and Message Not Sent!.');
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
			$query2 = "UPDATE assign_subtask SET complete_status=0 WHERE assigntaskID='$_GET[dr]'";
			if(mysqli_query($link,$query2))
			{
						
						$to=$assignsubtask_empmail;
						
						$subject="Your SubTask rejection is rejected ".$subtask_nme."";				//subject eka danna
						$msg1="Dear  ".$assignsubtask_empname."\r\n"
							."Your Subtask ".$subtask_nme." rejection request is rejected by the coordinator. \r\n"
							."Thank You\r\n"
							."WorkTracker\r\n";				
						
						$ok3=mail($to,$subject,$msg1);
						if($ok3){
							
							echo "<script>
								alert('Successfully Reject Decline this Sub Task and Message Sent!.');
								window.location.href='home.php';
							</script>";
						}
						else{
							
							echo "<script>
								alert('Successfully Reject Decline this Sub Task and Message Not Sent!.');
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

