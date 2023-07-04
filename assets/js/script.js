//Create arrays for current, shuffle and temp playlists. Declaring various variables.
var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist	= [];
var audioElement;
var userLoggedIn;
var timer;
var mouseDown = false; //indicates mouse button is being held down (dragged)
var repeat = false;
var shuffle = false;
var currentIndex = 0;

//console.log("LOADING SCRIPT.JS");

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

    var encodedUrl = encodeURI("views/pages/" + url + "&userLoggedIn=" + userLoggedIn);
    //console.log("REPOPULATING MAIN DIV = " + encodedUrl);

	$("#mainContent").load(encodedUrl, function () { //Load the new content
		$(this).fadeIn('slow');//Fade in the new content
	});

    $("body").scrollTop(0);
    //history.pushState(null, null, url);
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
	//console.log("RUNNING AUDIO FUNCTION");

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

function timeFromOffset(mouse, progressBar) {
    var percentage = mouse.offsetX / $(progressBar).width() * 100;
    var seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds);
}

function prevSong() {
    if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
        audioElement.setTime(0);
    }
    else {
        currentIndex = currentIndex - 1;
        setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
	}
}

function nextSong() {
    if (repeat) {
        audioElement.setTime(0);
        playSong();
        return;
    }

    if (currentIndex == currentPlaylist.length - 1) {
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
    
    if (repeat) { //Indicates repeat was enabled, change button colour
        if ($('.controlButton.repeat').removeClass('bg-purple-500') && $('.controlButton.repeat').addClass('bg-purple-800')) {
            //console.log("REPEAT BUTTON COLOR ENABLE SUCCESS!");
        } 
    } else { //Indicates repeat was disabled, revert button colour
        if ($('.controlButton.repeat').removeClass('bg-purple-800') && $('.controlButton.repeat').addClass('bg-purple-500')) {
            //console.log("REPEAT BUTTON COLOR DISABLE SUCCESS!");
        } 
    }
}

function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    /*var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
    $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);*/
}

function setShuffle() {
    shuffle = !shuffle;

    if (shuffle) { //Randomize playlist and change button colour
        shuffleArray(shufflePlaylist);
        currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);

        if ($('.controlButton.shuffle').removeClass('bg-purple-500') && $('.controlButton.shuffle').addClass('bg-purple-800')) {
            //console.log("SHUFFLE BUTTON TOGGLED!");
        } 
    }
    else { //shuffle has been disabled, go back to regular playlist and revert button colour
        currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);

        if ($('.controlButton.shuffle').removeClass('bg-purple-800') && $('.controlButton.shuffle').addClass('bg-purple-500')) {
            //console.log("SHUFFLE BUTTON TOGGLED BACK!");
        } 
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
	//console.log("setTrack Executing!");

    if (newPlaylist != currentPlaylist) {
        currentPlaylist = newPlaylist;
        shufflePlaylist = currentPlaylist.slice();
        shuffleArray(shufflePlaylist);
    }

    if (shuffle) {
        currentIndex = shufflePlaylist.indexOf(trackId);
    }
    else {
        currentIndex = currentPlaylist.indexOf(trackId);
    }
    pauseSong();

    //Ajax call, pass in handler location, function is what we wanna do with result!
    //This is so we can change the song without refreshing the page, PHP won't allow us to do it since server-side
    $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function (data) {

        //Create an object for this song/track using the data returned from Ajax call, set our trackname.
        var track = JSON.parse(data);
        $(".trackName span").hide().text(track.title).fadeIn("slow");//Title is the var name in our track object

        //nested ajax call to get Artist info, send in Artist ID encapsulated in track,
        $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function (data) {
            var artist = JSON.parse(data);
            $(".trackInfo .artistName span").hide().text(artist.name).fadeIn("slow");
            $(".trackInfo .artistName span").attr("onclick", "openPage('artistView.php?id=" + artist.id + "')");
        });

        //Another nested Ajax call, uses getAlbumJson ajax handler file, find album using track.album, then apply the data!
        $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function (data) {
            var album = JSON.parse(data);
            $(".content .albumLink img").attr("src", album.artworkPath).fadeIn("slow");
            $(".content .albumLink img").attr("onclick", "openPage('albumView.php?id=" + album.id + "')");
            $(".trackInfo .trackName span").attr("onclick", "openPage('albumView.php?id=" + album.id + "')");
        });

		audioElement.setTrack(track);
		//console.log("SETTING TRACK " + track.title + " ARTIST IS " + track.artist);

        if (play) {
            playSong();
		}

		setButtonFunctions();
    });

}

function playSong() {
    //Only wanna update playCount is the time is 0, otherwise pause/plays will cause increments.
    if (audioElement.audio.currentTime == 0) {
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

function setButtonFunctions() {
	//console.log("SETTING BUTTON FUNCTIONS");

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

	$("#play").off('click').on('click', function () {
		playSong();
		//console.log("Clicked Play");
	});

	$("#pause").off('click').on('click', function () {
		pauseSong();
		//console.log("Clicked Pause");
	});

	$("#previous").off('click').on('click', function () {
		prevSong();
		//console.log("Clicked Previous");
	});

	$("#next").off('click').on('click', function () {
		nextSong();
		//console.log("Clicked Next");
	});

	$("#shuffle").off('click').on('click', function () {
		setShuffle();
		//console.log("Clicked Shuffle");
	});

	$("#repeat").off('click').on('click', function () {
		setRepeat();
		//console.log("Clicked Repeat");
	});


}

function updateNowPlayingBar() {
    if (audioElement && audioElement.currentlyPlaying) {
        //console.log("NPB UPDATE " + audioElement.currentlyPlaying.title);
        $('.trackName span').hide().text(audioElement.currentlyPlaying.title).fadeIn("slow");

        // Fetch artist name and album artwork 
        $.post("includes/handlers/ajax/getArtistJson.php", { artistId: audioElement.currentlyPlaying.artist }, function (data) {
            var artist = JSON.parse(data);
			$(".trackInfo .artistName span").hide().text(artist.name).fadeIn("slow");
            $(".trackInfo .artistName span").attr("onclick", "openPage('artistView.php?id=" + artist.id + "')");
        });

        $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: audioElement.currentlyPlaying.album }, function (data) {
            var album = JSON.parse(data);
			$(".content .albumLink img").attr("src", album.artworkPath);
            $(".content .albumLink img").attr("onclick", "openPage('albumView.php?id=" + album.id + "')");
            $(".trackInfo .trackName span").attr("onclick", "openPage('albumView.php?id=" + album.id + "')");
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