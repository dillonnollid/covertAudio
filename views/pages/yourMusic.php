<?php
require(__DIR__ . '/../../includes/includedFiles.php');
?>

<div class="pageContainer">

	<div class="centerSection">

		<h2 class="generalCenteredText">Your Playlists</h2>
		<hr class="m-4">
		<?php
			$username = $_SESSION['userLoggedIn'];

			$playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

			if(mysqli_num_rows($playlistsQuery) == 0) {
				echo "<span class='errorText'>No playlists yet.</span>";
			}

			while($row = mysqli_fetch_array($playlistsQuery)) {
				$playlist = new Playlist($con, $row);

				echo "<div class='niceItem' role='link' tabindex='0' 
							onclick='openPage(\"playlistView.php?id=" . $playlist->getId() . "\")'>

						
						<div class='generalCenteredText'>"
							. $playlist->getName() .
						"</div>

					</div>";
			}

		echo "<button class='submitButton' onclick='createPlaylist()'>NEW PLAYLIST</button>";
		?>

	</div>
</div>