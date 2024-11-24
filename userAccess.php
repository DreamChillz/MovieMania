<?php
	include('loginAccess.php');
	if($role!="user"){
		header("location:AccessDenied.php");
	}
?>