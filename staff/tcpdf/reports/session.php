
<?php
include 'connect.php';
error_reporting(0);
session_start();
	$ses_user=$_SESSION['login_user'];
	$ses_level=$_SESSION['user_level'];
	$ses_ukey=$_SESSION['user_key'];
	
	$sql9999="SELECT * FROM staff WHERE empno='$ses_ukey'";
	$result9999=mysqli_query($link,$sql9999);
	$userinfo9999=mysqli_fetch_assoc($result9999);
	$uadmin_first=$userinfo9999['firstname'];
	$uadmin_last=$userinfo9999['lastname'];
	$uprofilepic=$userinfo9999['profile_pic'];
	$ucity=$userinfo9999['city'];
	$ucontact=$userinfo9999['contact_no'];
	$uemail=$userinfo9999['email'];
	$upass=$userinfo9999['password'];
	$uqualifications=$userinfo9999['qualifications'];

	$uadmin_fulln=$uadmin_first." ".$uadmin_last;
	
	if(!isset($_SESSION['login_user'])){
		header("location:../index.php");
	}


?>