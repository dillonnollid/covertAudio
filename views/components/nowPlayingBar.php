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

		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function (e) {
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

		$("#play").on('click touchstart', function () {
			playSong();
			console.log("Play");
		});

		$("#pause").on('click touchstart', function () {
			pauseSong();
			console.log("Pause");
		});

		$("#previous").on('click touchstart', function () {
			prevSong();
			console.log("Previous");
		});

		$("#next").on('click touchstart', function () {
			nextSong();
			console.log("Next");
		});

		$("#shuffle").on('click touchstart', function () {
			setShuffle();
			console.log("Shuffle");
		});

		$("#repeat").on('click touchstart', function () {
			setRepeat();
			console.log("Repeat");
		});
	});

	//Calculate time using the offset (where on the progress bar they clicked)
	
</script>

<div id="nowPlayingBarContainer"
	class="flex flex-col items-center justify-center font-semibold transition-colors text-black dark:text-white md:flex-row md:px-10">
	<!-- Outer div that holds the left, center and right divs-->
	<div id="nowPlayingBar" class="container mx-auto my-auto p-4 md:w-2/3">

		<div id="nowPlayingLeft" class="">
			<div class="content p-6 justify-center items-center mx-auto flex flex-col">
				<span class="albumLink">
					<img role="link" tabindex="0" src=""
						class="albumArtwork sm:w-60 sm:h-60 md:w-80 md:h-80 object-cover rounded-xl mx-auto hover:scale-105 duration-200 cursor-pointer">
				</span>

				<div class="trackInfo text-center p-4 flex flex-col">
					<span class="trackName font-bold cursor-pointer">
						<span role="link" tabindex="0"></span>
					</span>
					<br>
					<span class="artistName font-normal cursor-pointer">
						<span role="link" tabindex="0"></span>
					</span>
				</div>
			</div>
		</div>

		<div id="nowPlayingCenter">
			<div class="content playerControls px-4 py-2">
				<div class="buttons flex justify-between items-center md:px-4">
					<!--<button class="controlButton shuffle flex-auto w-14" title="Shuffle button" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>-->

					<button id="shuffle" title="Shuffle button" onclick=""
						class="controlButton shuffle w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:shadow-outline-blue">
						<i class="fa fa-random fa-2x text-white" aria-hidden="true"></i>
					</button>

					<button id="previous" title="Previous button" onclick=""
						class="controlButton previous w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:shadow-outline-blue">
						<i class="fa fa-backward fa-2x text-white"></i>
					</button>

					<button id="play" title="Play button" onclick=""
						class="controlButton play w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:shadow-outline-blue">
						<i class="fa fa-play fa-2x text-white" id="play-btn"></i>
					</button>

					<button id="pause" title="Pause button" onclick=""
						class="controlButton pause w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:shadow-outline-blue"
						style="display: none;">
						<i class="fa fa-pause fa-2x text-white" id="pause-btn"></i>
					</button>

					<button id="next" title="Next button" onclick=""
						class="controlButton next w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:shadow-outline-blue">
						<i class="fa fa-forward fa-2x text-white"></i>
					</button>

					<button id="repeat" title="Repeat button" onclick=""
						class="controlButton repeat w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:shadow-outline-blue">
						<i class="fa fa-repeat fa-2x text-white" aria-hidden="true"></i>
					</button>
				</div>

				<br>
				<div class="playbackBar flex flex-nowrap w-full gap-4 items-center justify-between text-md">
					<span class="progressTime current text-center w-8">0.00</span>

					<div class="progressBar inline-flex items-center w-full cursor-pointer h-2.5">
						<div class="progressBarBg bg-blue-gray-50 h-full w-full overflow-hidden rounded-md border-2">
							<div
								class="progress flex h-full items-baseline justify-center overflow-hidden break-all bg-gradient-to-tr from-purple-600 to-purple-400 text-white">
							</div>
						</div>
					</div>

					<span class="progressTime remaining text-center w-8">0.00</span>
				</div>


			</div>
		</div>

		<div id="nowPlayingRight">
			<div class="volumeBar flex flex-row w-full gap-4 items-center justify-between text-md">

				<button id="volume" title="Volume button" onclick="setMute()"
					class="controlButton volume w-12 h-12 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:shadow-outline-blue">
					<i class="fa  fa-volume-off fa-2x text-white" aria-hidden="true"></i>
				</button>

				<div class="progressBar h-full w-full overflow-hidden rounded-md">
					<div class="progressBarBg h-2 w-full rounded-lg border-2">
						<div
							class="progress flex h-full items-baseline justify-center overflow-hidden break-all bg-gradient-to-tr from-purple-600 to-purple-400 text-white">
						</div>
					</div>
				</div>

			</div>
		</div>

	</div><!-- END NOW PLAYING BAR -->

	<div class="container mx-auto p-4 h-full justify-center space-y-8">

		<div class="min-w-0 p-4 text-white bg-blue-600 rounded-lg shadow-xs h-1/3">
			<h4 class="mb-4 font-semibold">
				Hello, <?php echo $_SESSION['name']; ?>
			</h4>
			<p class="font-semibold">
				Username = <?php echo $_SESSION['userLoggedIn'];?>
				<br>
				ImagePath = <?php echo $_SESSION['profilePic']; ?>
				<br>
				Role = <?php echo $_SESSION['role']; ?>
			</p>
		</div>

		<div class="min-w-0 p-4 text-white bg-green-600 rounded-lg shadow-xs h-1/3">
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