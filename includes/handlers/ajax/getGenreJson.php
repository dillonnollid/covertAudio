<?php
include("../../config.php");

if(isset($_POST['genreId'])) {
	$genreId = $_POST['genreId'];

    //we get our con variable after including the config file
    $songQuery = mysqli_query($con, "SELECT * FROM songs WHERE genre='$genreId' ORDER BY RAND()");

	$resultArray = array();

    //Loop through array using a while loop, then push song IDs onto our array
    while ($row = mysqli_fetch_array($songQuery)) {
        array_push($resultArray, $row['id']);
    }
    //Convert array to JSON (Javascript Object Notation), so we can use it in our JS code
    echo json_encode($resultArray);
}

?>

