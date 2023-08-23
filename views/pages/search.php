<?php
require(__DIR__ . '/../../includes/includedFiles.php');

if(isset($_GET['term'])) {
	$term = urldecode($_GET['term']);
}
else {
	$term = "";
}
?>

<div class="searchContainer">
	<h4>Search for something</h4>
	<input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing..." onfocus="this.value = this.value">
</div>

<script>
    $(".searchInput").focus();

    $(function() {
        $(".searchInput").keyup(function() {
            clearTimeout(timer);

            timer = setTimeout(function() {
                var val = $(".searchInput").val();
                openPage("search.php?term=" + val);
            }, 1500);
        })
    })
</script>

<?php if($term == "") exit(); ?>

<table class="niceTable">
	<h2>SONGS</h2>
	<ul class="niceList">
		
		<?php
		$songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");

		if(mysqli_num_rows($songsQuery) == 0) {
			echo "<span class='noResults'>Nothing matching " . $term . "</span>";
		}

		$songIdArray = array();

		$i = 1;
		while($row = mysqli_fetch_array($songsQuery)) {

			if($i > 15) {
				break;
			}

			array_push($songIdArray, $row['id']);

			$albumSong = new models\Song( $row['id']);
			$albumArtist = $albumSong->getArtist();

			echo "<li class='niceItem'>
					<div class='trackCount'>
						<img class='playIcon' src='assets/images/icons/play.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>


					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getName() . "</span>
						<span class='artistName'>" . $albumArtist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
						<img class='optionsIcon' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
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

<div class="artistsContainer">

	<h2>ARTISTOS</h2>

	<?php
	$artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");
	
	if(mysqli_num_rows($artistsQuery) == 0) {
		echo "<span class='noResults'>No artists found matching " . $term . "</span>";
	}

	while($row = mysqli_fetch_array($artistsQuery)) {
		$artistFound = new models\Artist($row['id']);

		echo "<div class='searchResultRow'>
				<div class='artistName'>

					<span role='link' tabindex='0' onclick='openPage(\"artistView.php?id=" . $artistFound->getId() ."\")'>
					"
					. $artistFound->getName() .
					"
					</span>

				</div>

			</div>";
	}
	?>
</div>

<div class="gridViewContainer">
	<h2>ALBIMOS</h2>
	<?php
		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");

		if(mysqli_num_rows($albumQuery) == 0) {
			echo "<span class='noResults'>No albums found matching " . $term . "</span>";
		}

		while($row = mysqli_fetch_array($albumQuery)) {

			echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"albumView.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>

						<div class='gridViewInfo'>"
							. $row['title'] .
						"</div>
					</span>

				</div>";
		}
	?>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo models\Playlist::getPlaylistsDropdown($userLoggedIn->getUsername()); ?>
</nav>
