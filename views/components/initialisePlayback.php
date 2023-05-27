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
		audioElement = new Audio();

		//Set track
		setTrack(newPlaylist[0], newPlaylist, false);
		updateVolumeProgressBar(audioElement.audio);//Volume bar not yet implemented with tailwind player

		$("#nowPlayingBarContainer").on("mousedown click mousemove touchmove", function (e) {
			e.preventDefault();//prevents default behaviour for these events. Since we are coding their behaviour. Cannot highlight the buttons and stuff in now playing.
		});

		//When the mouse is being clicked down on those elements, then we turn on mouseDown.
		$(".playbackBar .progressBar").mousedown(function () {
			mouseDown = true;
		});

		//pass in e to mousemove, e is event, passing whatever called it in aswell, it'll pass in the mouse click object
		$(".playbackBar .progressBar").mousemove(function (e) {
			if (mouseDown == true) {
				//Set time of song, depending on position of mouse
				timeFromOffset(e, this);
			}
		});

		$(".playbackBar .progressBar").mouseup(function (e) {
			timeFromOffset(e, this);
		});

		$(".volumeBar .progressBar").mousedown(function () {
			mouseDown = true;
		});

		$(".volumeBar .progressBar").mousemove(function (e) {
			if (mouseDown == true) {
				var percentage = e.offsetX / $(this).width();

				if (percentage >= 0 && percentage <= 1) {
					audioElement.audio.volume = percentage;
				}
			}
		});

		$(".volumeBar .progressBar").mouseup(function (e) {
			var percentage = e.offsetX / $(this).width();

			if (percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
		});

		$(document).mouseup(function () {
			mouseDown = false;
		});

		$("#play").on('click', function () {
			playSong();
			//console.log("Play");
		});

		$("#pause").on('click', function () {
			pauseSong();
			//console.log("Pause");
		});

		$("#previous").on('click', function () {
			prevSong();
			//console.log("Previous");
		});

		$("#next").on('click', function () {
			nextSong();
			//console.log("Next");
		});

		$("#shuffle").on('click', function () {
			setShuffle();
			//console.log("Shuffle");
		});

		$("#repeat").on('click', function () {
			setRepeat();
			//console.log("Repeat");
		});
	});
	
</script>
