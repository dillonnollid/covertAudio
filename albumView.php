<?php
include("includes/includedFiles.php"); 

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

<div class="entityInfo flex flex-col md:flex-row justify-center items-center overflow-hidden m-8">
	<div class="leftSection p-8 justify-center items-center mx-auto">
		<img src="<?php echo $album->getArtworkPath(); ?>" class="shadow-2xl hover:shadow-2xl">
	</div>

	<div class="rightSection bg-blue-400 w-3/4 m-8 justify-center items-center text-center"><br>
		<h2 class="text-2xl"><?php echo $album->getTitle(); ?></h2><br>
		<p role="link" tabindex="0" onclick="openPage('artistView.php?id=$artistId')">By <?php echo $artist->getName(); ?></p><br>
		<p class="text-xl"><?php echo $album->getNumberOfSongs(); ?> songs</p><br>
	</div>

</div>

<!-- List of all tracks in the album, get all song IDs from album, iterate through and output HTML tracklistContainer flex-col bg-red-100-->
<div class=" justify-center items-center w-auto overflow-hidden m-6 rounded-xl shadow-xs">
    <table class="w-full whitespace-no-wrap">
        <ul class="tracklist list-none md:list-disc bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

            <?php
            $songIdArray = $album->getSongIds();

            $i = 1;
            foreach($songIdArray as $songId) {

                $albumSong = new Song($con, $songId);
                $albumArtist = $albumSong->getArtist();

                echo "<li class='flex justify-between items-center w-auto p-2 xs:h-40 md:h-20 '>
                        <div class='trackCount flex flex-row flex-auto basis-1/4 justify-around'>
                            <span class='trackNumber my-auto p-2 text-gray-700 dark:text-gray-400'>$i</span>
                            <img class='play my-auto w-10 h-10 p-2 cursor-pointer' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                        </div>
    
                        <div onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)' class='trackInfo flex flex-col flex-4 basis-2/4 justify-center items-center content-between '>
                            <span class='trackName font-medium h-1/2 text-gray-700 dark:text-gray-400 my-auto cursor-pointer'>" . $albumSong->getTitle() . "</span>
                            <span class='artistName font-light h-1/2 text-gray-700 dark:text-gray-400 my-auto cursor-pointer'>" . $albumArtist->getName() . "</span>
                        </div>
    
                        <div class='trackOptions flex flex-col flex-auto basis-1/4 items-center cursor-pointer'>
                            <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                            <img class='optionsButton w-8 h-8 my-auto' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                        </div>
    
                        <div class='trackDuration flex flex-col flex-2 basis-1/4 items-center'>
                            <span class='duration text-gray-700 dark:text-gray-400'>" . $albumSong->getDuration() . "</span>
                        </div>
    
                    </li>";

                $i = $i + 1;
            }

            ?>

            <script>
                var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
                tempPlaylist = JSON.parse(tempSongIds);
            </script>

        </ul>
    </table>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
	<div class="item">Item 2</div>
	<div class="item">Item 3</div>
</nav>