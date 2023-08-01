<?php
//Select 100 (max) random songs from the DB
$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 100");

$resultArray = array();

//Loop through array using a while loop, then push song IDs onto our array
while ($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['id']);
}
//Convert array to JSON (Javascript Object Notation), so we can use it in our JS code
$jsonArray = json_encode($resultArray);
?>

<script>
	$(document).ready(function () {
		//output json array into our newPlaylist object, create an Audio element (call func in script.js)
		var newPlaylist = <?php echo $jsonArray; ?>;

		//Set track
		setTrack(newPlaylist[0], newPlaylist, false);
		updateVolumeProgressBar(audioElement.audio);//Volume bar not yet implemented with tailwind player
	});
</script>
