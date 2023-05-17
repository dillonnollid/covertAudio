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
            console.log("REPEAT BUTTON COLOR SWITCH SUCCESS!");
        } 
    } else { //Indicates repeat was disabled, revert button colour
        if ($('.controlButton.repeat').removeClass('bg-purple-800') && $('.controlButton.repeat').addClass('bg-purple-500')) {
            console.log("REPEAT BUTTON COLOR REVERT SUCCESS!");
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
            console.log("SHUFFLE BUTTON COLOR SWITCH SUCCESS!");
        } 
    }
    else { //shuffle has been disabled, go back to regular playlist and revert button colour
        currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);

        if ($('.controlButton.shuffle').removeClass('bg-purple-800') && $('.controlButton.shuffle').addClass('bg-purple-500')) {
            console.log("SHUFFLE BUTTON COLOR REVERT SUCCESS!");
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
        $(".trackName span").text(track.title);//Title is the var name in our track object

        //nested ajax call to get Artist info, send in Artist ID encapsulated in track,
        $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function (data) {
            var artist = JSON.parse(data);
            $(".trackInfo .artistName span").text(artist.name);
            $(".trackInfo .artistName span").attr("onclick", "openPage('artistView.php?id=" + artist.id + "')");
        });

        //Another nested Ajax call, uses getAlbumJson ajax handler file, find album using track.album, then apply the data!
        $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function (data) {
            var album = JSON.parse(data);
            $(".content .albumLink img").attr("src", album.artworkPath);
            $(".content .albumLink img").attr("onclick", "openPage('albumView.php?id=" + album.id + "')");
            $(".trackInfo .trackName span").attr("onclick", "openPage('albumView.php?id=" + album.id + "')");
        });

        audioElement.setTrack(track);

        if (play) {
            playSong();
        }
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