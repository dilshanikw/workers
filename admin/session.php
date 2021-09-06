
<?php
include 'connect.php';
session_start();
	$ses_user=$_SESSION['login_user'];
	$ses_level=$_SESSION['user_level'];
	$ses_ukey=$_SESSION['user_key'];
	
	$sql9999="SELECT * FROM coordinator WHERE codinator_key='$ses_ukey'";
	$result9999=mysqli_query($link,$sql9999);
	$userinfo9999=mysqli_fetch_assoc($result9999);
	$uadmin_first=$userinfo9999['first_name'];
	$uadmin_last=$userinfo9999['lastname'];
	$uprofilepic=$userinfo9999['profile_pic'];
	$ucity=$userinfo9999['city'];
	$ucontact=$userinfo9999['contactno'];
	$uemail=$userinfo9999['email'];
	$upass=$userinfo9999['password'];
	$utheme=$userinfo9999['theme'];

	$uadmin_fulln=$uadmin_first." ".$uadmin_last;
	
	if(!isset($_SESSION['login_user'])){
		header("location:../index.php");
	}


?>