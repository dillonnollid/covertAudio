//Create arrays for current, shuffle and temp playlists. Declaring various variables.
var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false; //indicates mouse button is being held down (dragged)
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

//Global audio instance that will be used everywhere. 
audioElement = new Audio();

//Playlist dropdown menu functionality 
$(document).click(function(e) {
	var target = e.target;
	if (!$(target).is('.optionsMenu') && !$(target).parents().is('.optionsMenu') && !$(target).is('.optionsIcon')) {
		hideOptionsMenu();
	}
});

$(window).scroll(function() {
	hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
	var select = $(this);
	var playlistId = select.val();
	var songId = select.prev(".songId").val();

	$.post("includes/handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId})
	.done(function(error) {

		if(error != "") {
			alert(error);
			return;
		}

		hideOptionsMenu();
		select.val("");
	});
});

//Populate main container with the desired page e.g. browse.php or settings.php
function openPage(url) {

	if(timer != null) {
		clearTimeout(timer);
	}

	if(url.indexOf("?") == -1) {
		url = url + "?";
	}

	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	console.log(encodedUrl);
	console.log("REPOPULATING MAIN DIV");
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);
}

//Handle the creation and deletion of playlists using JS and Ajax
function createPlaylist() {
	var popup = prompt("Please enter the name of your playlist");

	if(popup != null) {
		$.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn })
		.done(function(error) {
			if(error != "") {
				alert(error);
				return;
			}
			//do something when ajax returns
			openPage("yourMusic.php");
		});
	}
}

function deletePlaylist(playlistId) {
	var prompt = confirm("Do you want to delete this playlist?");

	if(prompt == true) {
		$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
		.done(function(error) {
			if(error != "") {
				alert(error);
				return;
			}
			//do something when ajax returns
			openPage("yourMusic.php");
		});
	}
}

function showOptionsMenu(button) {
    var songId = $(button).prevAll(".songId").val();
    var menu = $(button).closest('.niceItem').find(".optionsMenu");
    menu.find(".songId").val(songId);

    menu.toggleClass('hidden');
}

function hideOptionsMenu() {
	$('.optionsMenu').addClass('hidden').removeClass('block');
}

//Formats timestamps into a display friendly variable!
function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60); //Rounds down
	var seconds = time - (minutes * 60);

	//Conditional statement, if seconds is less than 10, add 0, else add empty string
	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	//jQuery objects, any objects with both of those classes, update text with formatted times
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	//Calculates percentage of time remaining, applies to width attr
	var progress = audio.currentTime / audio.duration * 100;
	$(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
	var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {
	//Basically a class for audio, will instantiate in html, vars to hold current song, create an audio element on the page, 
	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	//Listening for the canplay event, when that event fires it'll execute that function! 
	this.audio.addEventListener("canplay", function() {
		//'this' refers to the object that the event was called on
		var duration = formatTime(this.duration);
		$(".progressTime.remaining").text(duration);
	});

	this.audio.addEventListener("timeupdate", function(){
		if(this.duration) { //basically means IF it has a duration, as long as it's not null
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
	});

	//Small functions for the audio object to change state, play and pause, set current time in song etc
	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}

}

function setButtonFunctions() {
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
		console.log("Play");
	});

	$("#pause").on('click', function () {
		pauseSong();
		console.log("Pause");
	});

	$("#previous").on('click', function () {
		prevSong();
		console.log("Previous");
	});

	$("#next").on('click', function () {
		nextSong();
		console.log("Next");
	});

	$("#shuffle").on('click', function () {
		setShuffle();
		console.log("Shuffle");
	});

	$("#repeat").on('click', function () {
		setRepeat();
		console.log("Repeat");
	});
}

function updateNowPlayingBar() {
    if (audioElement && audioElement.currentlyPlaying) {
        console.log("NPB UPDATE " + audioElement.currentlyPlaying.title);
        $('.trackName span').text(audioElement.currentlyPlaying.title);

        // Fetch artist name and album artwork 
        $.post("includes/handlers/ajax/getArtistJson.php", { artistId: audioElement.currentlyPlaying.artist }, function (data) {
            var artist = JSON.parse(data);
            $('.artistName span').text(artist.name);
        });

        $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: audioElement.currentlyPlaying.album }, function (data) {
            var album = JSON.parse(data);
            $('.albumArtwork').attr('src', album.artworkPath);
        });

        // Update controlButton states based on audio states, then check for shuffle and repeat
        if(audioElement.audio.paused) {
            $(".controlButton.play").show();
            $(".controlButton.pause").hide();
        } else {
            $(".controlButton.play").hide();
            $(".controlButton.pause").show();
        }

        if(shuffle) {
            $('.controlButton.shuffle').addClass('bg-purple-800').removeClass('bg-purple-500');
        } else {
            $('.controlButton.shuffle').addClass('bg-purple-500').removeClass('bg-purple-800');
        }

        if(repeat) {
            $('.controlButton.repeat').addClass('bg-purple-800').removeClass('bg-purple-500');
        } else {
            $('.controlButton.repeat').addClass('bg-purple-500').removeClass('bg-purple-800');
		}

		//Call the function to set button and playback functionalities
		setButtonFunctions();
		
    }
}