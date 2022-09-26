<?php
	//Starts the output buffering and session
	ob_start();
	session_start();

	$timezone = date_default_timezone_set("Europe/Dublin");
	//mysql object, 3rd param is password, 4th is DB name. Output error if failed to connect to DB! 
	$con = mysqli_connect("localhost", "root", "", "slotify");

	if(mysqli_connect_errno()) {
		echo "Failed to connect: " . mysqli_connect_errno();
	}
?>