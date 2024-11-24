<?php
	session_start();
	$user_id=$_SESSION['user_id'];
    $role = $_SESSION['role'];
	if($user_id==""){
		header("location:login.php");
	}
?>