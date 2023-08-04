<?php
require(__DIR__ . '/../../includes/includedFiles.php');

use controllers\CreateController;

$createController = new CreateController();

if (isset($_GET["id"]) && trim($_GET["id"]) == 'song') {
    echo "<script>openPage('addSongForm.php')</script>";
} elseif (isset($_GET["id"]) && trim($_GET["id"]) == 'artist') {
    echo "<script>openPage('addArtistForm.php')</script>";
} elseif (isset($_GET["id"]) && trim($_GET["id"]) == 'album') {
    echo "<script>openPage('addAlbumForm.php')</script>";
} elseif (isset($_GET["id"]) && trim($_GET["id"]) == 'genre') {
    echo "<script>openPage('addGenreForm.php')</script>";
}
?>
