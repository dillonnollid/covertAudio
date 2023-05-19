<?php
//Select 10 random songs from the DB, random playlist
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
	//Calculate time using the offset (where on the progress bar they clicked)
	
</script>

<div class="nowPlayingBarContainer">
	<!-- Outer div that holds the left, center and right divs-->
	<div class="nowPlayingBar">

		<div class="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img role="link" tabindex="0" src=""
						class="albumArtwork">
				</span>

				<div class="trackInfo">
					<span class="trackName">
						<span role="link" tabindex="0"></span>
					</span>
					<span class="artistName">
						<span role="link" tabindex="0"></span>
					</span>
				</div>
			</div>
		</div>

		<div id="nowPlayingCenter">
			<div class="content py-2">
				<div class="buttons">
					<!--<button class="controlButton shuffle flex-auto w-14" title="Shuffle button" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>-->

					<button id="shuffle" title="Shuffle button" class="controlButton shuffle bg-purple-500">
						<i class="fa fa-random fa-2x text-white"></i>
					</button>

					<button id="previous" title="Previous button" class="controlButton previous bg-purple-500">
						<i class="fa fa-backward fa-2x text-white"></i>
					</button>

					<button id="play" title="Play button" class="controlButton play bg-purple-500">
						<i class="fa fa-play fa-2x text-white" id="play-btn"></i>
					</button>

					<button id="pause" title="Pause button" class="controlButton pause bg-purple-500"
						style="display: none;">
						<i class="fa fa-pause fa-2x text-white" id="pause-btn"></i>
					</button>

					<button id="next" title="Next button" class="controlButton next bg-purple-500">
						<i class="fa fa-forward fa-2x text-white"></i>
					</button>

					<button id="repeat" title="Repeat button" class="controlButton repeat bg-purple-500">
						<i class="fa fa-repeat fa-2x text-white"></i>
					</button>
				</div>

				<br>
				<div class="playbackBar">
					<span class="progressTime current">0.00</span>

					<div class="progressBar">
						<div class="progressBarBg">
							<div
								class="progress">
							</div>
						</div>
					</div>

					<span class="progressTime remaining">0.00</span>
				</div>


			</div>
		</div>

		<!--<div id="nowPlayingRight">
			<div class="volumeBar">

				<button id="volume" title="Volume button" onclick="setMute()"
					class="controlButton volume">
					<i class="fa fa-volume-off fa-2x text-white" aria-hidden="true"></i>
				</button>

				<div class="progressBar">
					<div class="progressBarBg">
						<div class="progress">
						</div>
					</div>
				</div>

			</div>
		</div>-->

	</div><!-- END NOW PLAYING BAR -->

	<div class="messageContainer">

		<div class="messageBox">
			<h4 class="mb-4 font-semibold">
				Hello, <?php echo $_SESSION['name']; ?>
			</h4>
			<p class="font-semibold">
				Username = <?php echo $_SESSION['userLoggedIn'];?>
				<br>
				Email = <?php echo $_SESSION['email'];?>
				<br>
				ImagePath = <?php echo $_SESSION['profilePic']; ?>
				<br>
				Role = <?php echo $_SESSION['role']; ?>
			</p>
		</div>

		<div class="messageBox">
			<h4 class="mb-4 font-semibold">
				Rules and Regulations
			</h4>
			<p>
				You can upload your own music to this website!<br>
				Click the 'Contribute' button in the menu to start.<br>
				Be aware, you must only upload Copyright free music. <br>
				This site is for sharing royalty free tunes<br>
				If it's on Spotify, it doesn't belong here!<br>
			</p>
		</div>

	</div>

</div>