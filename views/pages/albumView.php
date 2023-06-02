<?php 
require(__DIR__ . '/../../includes/includedFiles.php');

//Make sure we have an album ID in our get array (from URL), else we wanna redirect them back to index
if(isset($_GET['id'])) {
	$albumId = $_GET['id'];
}
else {
	header("Location: index.php");
}

//Create new Album object, pass in our DB conn and the ID of the album to retrieve all album info
$album = new Album($con, $albumId);

//Get artist from our Album object, then get the Artist ID from the new Artist object!
$artist = $album->getArtist();
$artistId = $artist->getId();
?>

<!--<div class="actionTextBar">
    <span class="colourText cursor-pointer" role="link" tabindex="0" onclick="openPage('browse.php')">&larr; Back to Home</span>
</div>-->

<div class="pageContainer">

	<div class="leftSection">
		<img class="imageAnimation" src="<?php echo $album->getArtworkPath(); ?>">
	</div>

	<div class="rightSection"><br>
		<h2 class="text-2xl"><?php echo $album->getTitle(); ?></h2><br>
		<p role="link" tabindex="0" onclick="openPage('artistView.php?id=$artistId')">By <?php echo $artist->getName(); ?></p><br>
		<p class="text-xl"><?php echo $album->getNumberOfSongs(); ?> songs</p><br>
        <span class="themedText cursor-pointer hover:underline" role="link" tabindex="0" onclick="openPage('browse.php')">&larr; Back to Home</span>
	</div>

</div>

<div class="tableContainer">
    <table class="niceTable">
        <ul class="niceList">
            <?php
            $songIdArray = $album->getSongIds();

            $i = 1;
            foreach($songIdArray as $songId) {
                $albumSong = new Song($con, $songId);
                $albumArtist = $albumSong->getArtist();
            
                echo "<li class='niceItem'>
                        <div class='trackCount'>
                            <span class='trackNumber'>$i</span>
                            <img class='playIcon' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                        </div>
            
                        <div class='trackInfo' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                            <span class='trackName'>" . $albumSong->getTitle() . "</span>
                            <span class='artistName'>" . $albumArtist->getName() . "</span>
                        </div>
            
                        <div class='trackOptions'>
                            <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                            <img class='optionsIcon' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                        
                            <nav class='optionsMenu absolute hidden w-40 bg-gray-50 dark:bg-gray-700 shadow-lg rounded-md p-3'>
                                <input type='hidden' class='songId'>
                                ". Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()) ."
                            </nav>
                        </div>
            
                        <div class='trackDuration'>
                            <span class='durationText'>" . $albumSong->getDuration() . "</span>
                        </div>
                    </li>";
            
                $i = $i + 1;
            } ?>

            <script>
                var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
                tempPlaylist = JSON.parse(tempSongIds);
            </script>

        </ul>
    </table>
</div>



