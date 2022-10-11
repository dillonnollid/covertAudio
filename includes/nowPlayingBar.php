<?php
//Select 10 random songs from the DB, random playlist
$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

//Loop through array using a while loop, then push song IDs onto our array
while($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['id']);
}
//Convert array to JSON (Javascript Object Notation), so we can use it in our JS code
$jsonArray = json_encode($resultArray);
?>

<script>
$(document).ready(function() {
	//output json array into our newPlaylist object, create an Audio element (call func in script.js)
	var newPlaylist = <?php echo $jsonArray; ?>;
	audioElement = new Audio();

	//Set track
	setTrack(newPlaylist[0], newPlaylist, false);
	updateVolumeProgressBar(audioElement.audio);//Volume bar not yet implemented with tailwind player

	$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
		e.preventDefault();//prevents default behaviour for these events. Since we are coding their behaviour. Cannot highlight the buttons and stuff in now playing.
	});

	//When the mouse is being clicked down on those elements, then we turn on mouseDown.
	$(".playbackBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	//pass in e to mousemove, e is event, passing whatever called it in aswell, it'll pass in the mouse click object
	$(".playbackBar .progressBar").mousemove(function(e) {
		if(mouseDown == true) {
			//Set time of song, depending on position of mouse
			timeFromOffset(e, this);
		}
	});

	$(".playbackBar .progressBar").mouseup(function(e) {
		timeFromOffset(e, this);
	});

	$(".volumeBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".volumeBar .progressBar").mousemove(function(e) {
		if(mouseDown == true) {
			var percentage = e.offsetX / $(this).width();

			if(percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
		}
	});

	$(".volumeBar .progressBar").mouseup(function(e) {
		var percentage = e.offsetX / $(this).width();

		if(percentage >= 0 && percentage <= 1) {
			audioElement.audio.volume = percentage;
		}
	});

    $(document).mouseup(function() {
        mouseDown = false;
    });

    $("#play").on('click touchstart',function(){
        playSong();
        console.log("Play");
    });

    $("#pause").on('click touchstart',function(){
        pauseSong();
        console.log("Pause");
    });

    $("#previous").on('click touchstart',function(){
        prevSong();
        console.log("Previous");
    });

    $("#next").on('click touchstart',function(){
        nextSong();
        console.log("Next");
    });

    $("#shuffle").on('click touchstart',function(){
        setShuffle();
        console.log("Shuffle");
    });

    $("#repeat").on('click touchstart',function(){
        setRepeat();
        console.log("Repeat");
    });
});

//Calculate time using the offset (where on the progress bar they clicked)
function timeFromOffset(mouse, progressBar) {
	var percentage = mouse.offsetX / $(progressBar).width() * 100;
	var seconds = audioElement.audio.duration * (percentage / 100);
	audioElement.setTime(seconds);
}

function prevSong() {
	if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
		audioElement.setTime(0);
	}
	else {
		currentIndex = currentIndex - 1;
		setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
	}
}

function nextSong() {
	if(repeat == true) {
		audioElement.setTime(0);
		playSong();
		return;
	}

	if(currentIndex == currentPlaylist.length - 1) {
		currentIndex = 0;
	}
	else {
		currentIndex++;
	}

	var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
	setTrack(trackToPlay, currentPlaylist, true);
}

//Buttons/Icons not yet implemented on tailwind player
function setRepeat() {
	repeat = !repeat;
	var imageName = repeat ? "repeat-active.png" : "repeat.png";
	$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
}

function setMute() {
	audioElement.audio.muted = !audioElement.audio.muted;
	var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
	$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}

function setShuffle() {
	shuffle = !shuffle;
	var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
	$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

	if(shuffle == true) {
		//Randomize playlist
		shuffleArray(shufflePlaylist);
		currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
	}
	else {
		//shuffle has been deactivated
		//go back to regular playlist
		currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
	}
}

function shuffleArray(a) {
    var j, x, i;
    for (i = a.length; i; i--) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }
}


function setTrack(trackId, newPlaylist, play) {

	if(newPlaylist != currentPlaylist) {
		currentPlaylist = newPlaylist;
		shufflePlaylist = currentPlaylist.slice();
		shuffleArray(shufflePlaylist);
	}

	if(shuffle == true) {
		currentIndex = shufflePlaylist.indexOf(trackId);
	}
	else {
		currentIndex = currentPlaylist.indexOf(trackId);
	}
	pauseSong();

	//Ajax call, pass in handler location, function is what we wanna do with result!
	//This is so we can change the song without refreshing the page, PHP won't allow us to do it since server-side
	$.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {

		//Create an object for this song/track using the data returned from Ajax call, set our trackname.
		var track = JSON.parse(data);
		$(".trackName span").text(track.title);//Title is the var name in our track object

		//nested ajax call to get Artist info, send in Artist ID encapsulated in track,
		$.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
			var artist = JSON.parse(data);
			$(".trackInfo .artistName span").text(artist.name);
			$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
		});

		//Another nested Ajax call, uses getAlbumJson ajax handler file, find album using track.album, then apply the data!
		$.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
			var album = JSON.parse(data);
			$(".content .albumLink img").attr("src", album.artworkPath);
			$(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
			$(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
		});

		audioElement.setTrack(track);

		if(play == true) {
			playSong();
		}
	});

}

function playSong() {
	//Only wanna update playCount is the time is 0, otherwise pause/plays will cause increments.
	if(audioElement.audio.currentTime == 0) {
		$.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
	}
	$(".controlButton.play").hide();
	$(".controlButton.pause").show();
	audioElement.play();
}

function pauseSong() {
	$(".controlButton.play").show();
	$(".controlButton.pause").hide();
	audioElement.pause();
}
</script>
<!-- Now Playing Container zinc-->

<div id="nowPlayingBarContainer" class="flex flex-col items-center justify-center bg-blue-100 md:flex-row"><!-- max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl -->
    <!-- Outer div that holds the left, center and right divs-->
	<div id="nowPlayingBar" class="container mx-auto p-4 bg-green-100">

		<div id="nowPlayingLeft" class="">
			<div class="content p-6 justify-center items-center mx-auto bg-orange-100 flex flex-col">
				<span class="albumLink">
					<img role="link" tabindex="0" src="" class="albumArtwork object-cover rounded-xl mx-auto hover:scale-105 duration-200">
				</span>

				<div class="trackInfo text-center p-4">
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
			<div class="content playerControls p-4">
				<div class="buttons flex justify-between items-center md:px-4">
					<!--<button class="controlButton shuffle flex-auto w-14" title="Shuffle button" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>-->

                    <button id="shuffle" title="Shuffle button" onclick="" class="controlButton shuffle w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        <i class="fa fa-random fa-2x text-white" aria-hidden="true"></i>
                    </button>

					<button id="previous" title="Previous button" onclick="" class="controlButton previous w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" >
                        <i class="fa fa-backward fa-2x text-white"></i>
					</button>

					<button id="play" title="Play button" onclick="" class="controlButton play w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" >
                        <i class="fa fa-play fa-2x text-white" id="play-btn"></i>
					</button>

					<button id="pause" title="Pause button" onclick="" class="controlButton pause w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"  style="display: none;">
                        <i class="fa fa-pause fa-2x text-white" id="pause-btn"></i>
					</button>

					<button id="next" title="Next button" onclick="" class="controlButton next w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" >
                        <i class="fa fa-forward fa-2x text-white"></i>
					</button>

					<button id="repeat" title="Repeat button" onclick="" class="controlButton repeat w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue" >
                        <i class="fa fa-repeat fa-2x text-white" aria-hidden="true"></i>
					</button>
				</div>

				<!-- PBB has text for current and remaining time, which we manupulate using JS -->
				<div class="playbackBar flex items-center justify-between">
					<span class="progressTime current p-6">0.00</span>

					<div class="progressBar">
						<div class="progressBarBg">
							<div class="progress"></div>
						</div>
					</div>

					<span class="progressTime remaining p-6">0.00</span>
				</div>
			</div>
		</div>

		<div id="nowPlayingRight">
			<div class="volumeBar">

				<button id="volume" title="Volume button" onclick="setMute()" class="controlButton volume w-14 h-14 rounded-full text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    <i class="fa  fa-volume-off fa-2x text-white" aria-hidden="true"></i>
				</button>

				<div class="progressBar">
					<div class="progressBarBg">
						<div class="progress"></div>
					</div>
				</div>

			</div>
		</div>

	</div><!-- END NOW PLAYING BAR -->

    <div class="container mx-auto p-4 bg-green-100 h-full">
        TESTING RIGHT SIDE (UNDER ON MOBILE)
        <div class="min-w-0 p-4 text-white bg-blue-600 rounded-lg shadow-xs">
            <h4 class="mb-4 font-semibold">
                Colored card
            </h4>
            <p>
                Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                Fuga, cum commodi a omnis numquam quod? Totam exercitationem
                quos hic ipsam at qui cum numquam, sed amet ratione! Ratione,
                nihil dolorum.
            </p>
        </div>
    </div>
</div>