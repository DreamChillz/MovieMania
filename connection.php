<?php

	$HostName="localhost";
	
	$User_mysql="root";
	
	$Password_mysql="";

	$connect = mysqli_connect($HostName, $User_mysql, $Password_mysql) or 
		die("Sorry, Database is not connected!");
		
	$pdata_mysql="moviemania";
	
	mysqli_select_db($connect, $pdata_mysql) or
		die("Database not selected!");
		
?>