<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	include("config.php");

	//$userLoggedIn;
	if(isset($_GET['userLoggedIn'])) {
		$userLoggedIn = new models\User($_GET['userLoggedIn']);
	} else {
		echo "Username variable was not passed into page. Check the openPage JS function";
		exit();
	}
} else {
    include_once __DIR__ . '/../views/components/header.php';

	echo '<script>openPage("browse.php");</script>';

	//$url = $_SERVER['REQUEST_URI'];
	//echo "<script>openPage('$url')</script>";

    include_once __DIR__ . '/../views/components/footer.php';
	exit();
}
?>