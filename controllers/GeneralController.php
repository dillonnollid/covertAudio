<?php

class GeneralController{
    private $con;

    public function __construct(){
        
    }

    public function showGenreButtons() {
        // Get all genres using the new static method
        $genres = models\Genre::getGenreObjects();
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