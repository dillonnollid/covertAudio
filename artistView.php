<?php
include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$artistId = $_GET['id'];
}
else {
	header("Location: index.php");
}

$artist = new Artist($con, $artistId);
?>

<div class="entityInfo flex flex-col md:flex-row justify-center items-center overflow-hidden m-8 p-8">
	<div class="centerSection p-8 justify-center items-center mx-auto">
		<div class="artistInfo bg-purple-400 w-3/4 m-8 justify-center items-center text-center">
			<h1 class="artistName"><?php echo $artist->getName(); ?></h1>
			<hr>
			<div class="headerButtons">
				<button class="button" onclick="playFirstSong()">PLAY SONGS</button>
			</div>
		</div>
	</div>
</div>

<div class="tracklistContainer justify-center items-center w-auto overflow-hidden m-6 rounded-xl shadow-xs">
	<table class="w-full whitespace-no-wrap">
		<ul class="tracklist list-none md:list-disc bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
			
			<?php
			$songIdArray = $artist->getSongIds();

			$i = 1;
			foreach($songIdArray as $songId) {
				/*if($i > 5) {
					break;
				}*/

				$albumSong = new Song($con, $songId);
				$albumArtist = $albumSong->getArtist();

				echo "<li class='flex justify-between items-center w-auto p-2 xs:h-40 md:h-20'>
						<div class='trackCount flex flex-row flex-auto basis-1/4 justify-around'>
							<img class='play my-auto w-10 h-10 p-2 cursor-pointer' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
							<span class='trackNumber my-auto p-2 text-gray-700 dark:text-gray-400'>$i</span>
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

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>