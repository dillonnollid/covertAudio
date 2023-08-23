<?php
namespace models;

class Genre extends General {

    public function __construct($id) {
        $this->id = $id;
        $this->con = Database::getInstance()->getConnection();

        //Query on object creation, store result array in $this->mysqliData, then call setProperties() to set properties values
        $this->mysqliData = $this->getProperties();
        $this->setProperties($this->mysqliData);
    }

    public function getProperties(){
        $query = mysqli_query($this->con, "SELECT * FROM genres WHERE id='$this->id'");
        return mysqli_fetch_array($query);
    }

    public function setProperties($mysqliData){
        $this->name = $mysqliData['name'];
    }

    public function getMysqliData() {
        return $this->mysqliData;
    }

    public function getGenreSongCount() {
        $query = mysqli_query($this->con, "SELECT id FROM songs WHERE genre=$this->id");
        return mysqli_num_rows($query);
    }

    /* Static Methods Below */
    public static function getGenreObjects() {
        $genres = array();

        // Query to get all genres from the database
        $query = mysqli_query(Database::getInstance()->getConnection(), "SELECT * FROM genres");

        while ($row = mysqli_fetch_array($query)) {
            // Create Genre objects and store them in the $genres array
            $genres[] = new Genre($row['id']);
        }

        return $genres;
    }

    public static function getGenreCount() {
        // Query to get the count of all artists from the database
        $query = mysqli_query(Database::getInstance()->getConnection(), "SELECT COUNT(id) AS genre_count FROM genres");

        // Fetch the single result value
        $row = mysqli_fetch_assoc($query);
        $genreCount = $row['genre_count'];

        return $genreCount;
    }

}
?>