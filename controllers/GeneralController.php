<?php
require_once dirname(__DIR__) . '/models/Genre.php';
require_once dirname(__DIR__) . '/includes/config.php';

class GeneralController{
    private $con;

    public function __construct(){
        
    }

    public function showGenreButtons($con) {
        // Get all genres using the new static method
        $genres = Genre::getGenreObjects($con);
        foreach($genres as $genre){
            //Only display genre to user if it has at least 1 song
            if($genre->getGenreSongCount() > 0){
                echo '<button title="' . $genre->getName() . '" onclick="setQuickPlay(' . $genre->getId() . ', tempPlaylist, true)" class="w-auto">' .
                        $genre->getName() .
                    '</button>';
            }
            
        }

    }
}
?>