<div class="nowPlayingBarContainer">

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
					<!-- OLD BUTTON STRUCTURE <button class="controlButton shuffle flex-auto w-14" title="Shuffle button" onclick="setShuffle()">
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