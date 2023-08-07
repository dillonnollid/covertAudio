<?php
    use models\Database;//Singleton Database Connection Object

	//Starts the output buffering and session
	ob_start();

	if(session_status() == PHP_SESSION_NONE) { //session has not started
		session_start();
	}

    //Load the env file variables using the Dotenv package
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
	$dotenv->load();

	$timezone = date_default_timezone_set("Europe/Dublin");

    // Get the instance of the database connection
    $con = Database::getInstance()->getConnection();
?>