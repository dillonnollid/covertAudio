<?php
include("includes/includedFiles.php");
?>

<div class="pageContainer">

	<div class="centerSection">

		<h2 class="generalCenteredText">Your Playlists</h2>

		<?php
			$username = $_SESSION['userLoggedIn'];
			echo "Hi, " . $username . "<br>";

			$playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

			if(mysqli_num_rows($playlistsQuery) == 0) {
				echo "<span class='errorText'>No playlists yet.</span>";
			}

			while($row = mysqli_fetch_array($playlistsQuery)) {
				$playlist = new Playlist($con, $row);

				echo "<div class='niceItem' role='link' tabindex='0' 
							onclick='openPage(\"playlistView.php?id=" . $playlist->getId() . "\")'>

						
						<div class='gridViewInfo'>"
							. $playlist->getName() .
						"</div>

					</div>";
			}
		?>

		<div class="">
			<button class="submitButton" onclick="createPlaylist()">NEW PLAYLIST</button>
		</div>
	</div>
</div>