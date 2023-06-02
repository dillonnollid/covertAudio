<?php
require(__DIR__ . '/../../includes/includedFiles.php');

if(isset($_GET['id'])) {
	$artistId = $_GET['id'];
}
else {
	header("Location: index.php");
}

$artist = new Artist($con, $artistId);
?>

<div class="pageContainer p-8">
	<div class="leftSection">
		<div class="artistInfo bg-purple-400 w-3/4 m-8 justify-center items-center text-center">
			<h1 class="artistName themedText"><?php echo $artist->getName(); ?></h1>
			<hr>
			<div class="headerButtons">
				<button class="button" onclick="playFirstSong()">PLAY SONGS</button>
			</div>
			<span class="themedText cursor-pointer hover:underline" role="link" tabindex="0" onclick="openPage('browse.php')">&larr; Back to Home</span>
		</div>
	</div>
</div>

<div class="tableContainer">
	<table class="niceTable">
		<ul class="niceList ">
			
			<?php
			$songIdArray = $artist->getSongIds();

			$i = 1;
			foreach($songIdArray as $songId) {
				$albumSong = new Song($con, $songId);
				$albumArtist = $albumSong->getArtist();

				echo "<li class='niceItem'>
					<div class='trackCount'>
						<img class='playIcon' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>

					<div class='trackInfo' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>" . $albumArtist->getName() . "</span>
					</div>

					<div class='trackOptions position-relative'>
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
			}
			?>

			<script>
				var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
				tempPlaylist = JSON.parse(tempSongIds);
			</script>

		</ul>
	</table>
</div>

<!--<div class="gridViewContainer">
	<h2>ALBUMS</h2>
	<?php
		/*$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");

		while($row = mysqli_fetch_array($albumQuery)) {
			echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"albumView.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>

						<div class='gridViewInfo'>"
							. $row['title'] .
						"</div>
					</span>
				</div>";
		}*/
	?>
</div>-->