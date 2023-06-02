<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	include("config.php");
	include(__DIR__ . "/../models/User.php");
	include(__DIR__ . "/../models/Artist.php");
	include(__DIR__ . "/../models/Album.php");
	include(__DIR__ . "/../models/Song.php");
	include(__DIR__ . "/../models/Playlist.php");
	include(__DIR__ . "/../models/Genre.php");

	$userLoggedIn;
	if(isset($_GET['userLoggedIn'])) {
		$userLoggedIn = new User($con, $_GET['userLoggedIn']);
	} else {
		echo "Username variable was not passed into page. Check the openPage JS function";
		exit();
	}
} else {
	include("views/components/header.php");

	$url = $_SERVER['REQUEST_URI'];
	echo '<script>openPage("browse.php");</script>';
	//echo "<script>openPage('$url')</script>";
    include("views/components/footer.php");
	exit();
}
?>