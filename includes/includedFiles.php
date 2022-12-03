<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	include("includes/config.php");
	include("includes/classes/User.php");
	include("includes/classes/Artist.php");
	include("includes/classes/Album.php");
	include("includes/classes/Song.php");
	include("includes/classes/Playlist.php");
	include("includes/classes/Genre.php");

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