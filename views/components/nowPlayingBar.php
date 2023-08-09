<div class="nowPlayingBarContainer">

	<div class="nowPlayingBar">

		<div class="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img role="link" tabindex="0" src="" class="albumArtwork" alt="Album Artwork">
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

					<button id="shuffle" title="Shuffle button" class="controlButton shuffle bg-cyan-500 dark:bg-purple-500">
						<i class="fa fa-random fa-2x text-white"></i>
					</button>

					<button id="previous" title="Previous button" class="controlButton previous bg-cyan-500 dark:bg-purple-500">
						<i class="fa fa-backward fa-2x text-white"></i>
					</button>

					<button id="play" title="Play button" class="controlButton play bg-cyan-500 dark:bg-purple-500">
						<i class="fa fa-play fa-2x text-white" id="play-btn"></i>
					</button>

					<button id="pause" title="Pause button" class="controlButton pause bg-cyan-500 dark:bg-purple-500"
						style="display: none;">
						<i class="fa fa-pause fa-2x text-white" id="pause-btn"></i>
					</button>

					<button id="next" title="Next button" class="controlButton next bg-cyan-500 dark:bg-purple-500">
						<i class="fa fa-forward fa-2x text-white"></i>
					</button>

					<button id="repeat" title="Repeat button" class="controlButton repeat bg-cyan-500 dark:bg-purple-500">
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

	</div><!-- END NOW PLAYING BAR -->

	<div class="messageContainer">

	<div class="messageBox">
			<h4 class="mb-4 font-semibold">
				Hello, <?php echo $_SESSION['name']; ?>
			</h4>
			<p class="font-semibold">
				Username (Required for log in):<br>
                <?php echo $_SESSION['userLoggedIn'];?>
				<br>
				Email (Can be changed in settings page):<br> 
                <?php echo $_SESSION['email'];?>
				
			</p>
		</div>

		<div class="messageBox">
			<h4 class="mb-4 font-semibold">
				Quick Play Genres
			</h4>
			<ul class="list-disc text-wrap flex flex-col">
				<?php 
					$musicController->showGenreButtons();
				?>


			</ul>
		</div>

	</div>

</div>

<script>
	updateNowPlayingBar();
</script>

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