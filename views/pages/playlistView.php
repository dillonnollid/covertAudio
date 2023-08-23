<?php 
require(__DIR__ . '/../../includes/includedFiles.php');

if(isset($_GET['id'])) {
	$playlistId = $_GET['id'];
}
else {
	header("Location: index.php");
}

$playlist = new models\Playlist($playlistId);
$owner = new models\User($playlist->getOwner());
?>

<div class="pageContainer">

	<div class="leftSection">
		<img class="imageAnimation" src="assets/images/icons/playlist.png">
	</div>

	<div class="rightSection">
		<h2 class="text-2xl"></h2><?php echo $playlist->getName(); ?></h2>
		<p>By <?php echo $playlist->getOwner(); ?></p>
		<p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
		<span class="themedText cursor-pointer hover:underline" role="link" tabindex="0" onclick="openPage('browse.php')">&larr; Back to Home</span>
        <br>
		<button class="button" onclick="deletePlaylist('<?php echo $playlistId; ?>')">DELETE PLAYLIST</button>
	</div>

</div>

<div class="tableContainer">
	<table class="niceTable">
		<ul class="niceList">
			
			<?php
            $songIdArray =  $playlist->getPlaylistSongs();

			$i = 1;
			foreach($songIdArray as $songId) {

				$playlistSong = new models\Song($songId);
				$songArtist = $playlistSong->getArtist();

				echo "<li class='niceItem'>
						<div class='trackCount'>
							<img class='playIcon' src='assets/images/icons/play.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
							<span class='trackNumber'>$i</span>
						</div>

						<div class='trackInfo' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
							<span class='trackName'>" . $playlistSong->getName() . "</span>
							<span class='artistName'>" . $songArtist->getName() . "</span>
						</div>

						<div class='trackOptions'>
                            <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
                            <img class='optionsIcon' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                        
                            <nav class='optionsMenu absolute hidden w-40 bg-gray-50 dark:bg-gray-700 shadow-lg rounded-md p-3'>
                                <input type='hidden' class='songId'>
                                ". models\Playlist::getPlaylistsDropdown($userLoggedIn->getUsername()) ."
                            </nav>
                        </div>

						<div class='trackDuration'>
							<span class='trackName'>" . $playlistSong->getDuration() . "</span>
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
