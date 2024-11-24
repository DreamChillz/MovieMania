<?php
	include('loginAccess.php');
	if($role!="admin"){
		header("location:AccessDenied.php");
	}
?>