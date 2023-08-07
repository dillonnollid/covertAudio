<?php
namespace controllers;

use models\Artist;
use models\Album;
use models\Database;
use models\Genre;
use models\Playlist;
use models\Song;

class MusicController {

    public function __construct(){

    }

    public function showGenreButtons() {
        // Get all genres using the new static method
        $genres = Genre::getGenreObjects();
        foreach ($genres as $genre) {
            //Only display genre to the user if it has at least 1 song
            if ($genre->getGenreSongCount() > 0) {
                echo '<button title="' . $genre->getName() . '" onclick="setQuickPlay(' . $genre->getId() . ', tempPlaylist, true)" class="w-auto">' .
                    $genre->getName() .
                    '</button>';
            }
        }
    }

    public function getTotalSongCount() {
        return Song::getSongCount();
    }

    public function getTotalAlbumCount() {
        return Album::getAlbumCount();
    }

    public function getTotalArtistCount() {
        return Artist::getAlbumCount();
    }

    public function getTotalGenreCount() {
        return Genre::getGenreCount();
    }

    public function getAllSongs(){
        return Song::getAllSongs();
    }

    public function getArtistById($artistId) {
        return new Artist($artistId);
    }

    public function getAlbumById($albumId) {
        return new Album($albumId);
    }

    public function getGenreById($genreId) {
        return new Genre($genreId);
    }

    public function getSongById($songId) {
        return new Song($songId);
    }

    public function printUserPlaylists() {
        $playlists = Playlist::getUserPlaylists();

        $output = "";

        if(sizeof($playlists) == 0) {
            $output.= "<span class='errorText'>No playlists yet.</span>";
        }

        foreach ($playlists as $playlist){
            $output.= "<div class='niceItem' role='link' tabindex='0' 
							onclick='openPage(\"playlistView.php?id=" . $playlist['id'] . "\")'>

						
						<div class='generalCenteredText'>"
                . $playlist['name'] .
                "</div>

					</div>";
        }

        return $output;
    }
}
?>
