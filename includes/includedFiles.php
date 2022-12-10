<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	include("includes/config.php");
	include("models/User.php");
	include("models/Artist.php");
	include("models/Album.php");
	include("models/Song.php");
	include("models/Playlist.php");
	include("models/Genre.php");

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