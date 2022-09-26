<?php
include("../../config.php");

//If the song ID has been passed in, assign to a var, find the song using a query, encode and return the json data. 
if(isset($_POST['songId'])) {
	$songId = $_POST['songId'];

//we get our con variable after including the config file
	$query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");

	$resultArray = mysqli_fetch_array($query);

	echo json_encode($resultArray);
}

?>