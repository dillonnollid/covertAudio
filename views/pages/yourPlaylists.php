<?php
require(__DIR__ . '/../../includes/includedFiles.php');
$musicController = new controllers\MusicController();

?>

<div class="pageContainer">

	<div class="centerSection">

		<h2 class="generalCenteredText">Your Playlists</h2>
		<hr class="m-4">
		<?php
            $output = $musicController->printUserPlaylists();
            echo $output;
		?>
        <button class='submitButton' onclick='createPlaylist()'>NEW PLAYLIST</button>
	</div>
</div>