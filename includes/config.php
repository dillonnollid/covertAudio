<?php
	//Starts the output buffering and session
	ob_start();

	if(session_status() == PHP_SESSION_NONE) { //session has not started
		session_start();
	}

	require_once dirname(__DIR__) . '/vendor/autoload.php';
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
	$dotenv->load();

	$dbHost = $_ENV['DB_HOST'];
	$dbUsername = $_ENV['DB_USERNAME'];
	$dbPassword = $_ENV['DB_PASSWORD'];
	$dbDatabase = $_ENV['DB_DATABASE'];

	$timezone = date_default_timezone_set("Europe/Dublin");
	//mysql object, 3rd param is password, 4th is DB name. Output error if failed to connect to DB! 
	$con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);

	if(mysqli_connect_errno()) {
		echo "Failed to connect: " . mysqli_connect_errno();
	}
?>