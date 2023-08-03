<?php
namespace models;

use models\Database;

class Genre {

    private $con;
    private $id;
    private $mysqliData;
    private $name;

    public function __construct($id) {
        $this->id = $id;
        $this->con = Database::getInstance()->getConnection();

        //Query on creation, store data in myslqiData array and assign the vars values
        $query = mysqli_query($this->con, "SELECT * FROM genres WHERE id='$this->id'");
        $this->mysqliData = mysqli_fetch_array($query);
        $this->name = $this->mysqliData['name'];
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getMysqliData() {
        return $this->mysqliData;
    }

    public function getGenreSongCount() {
        $query = mysqli_query($this->con, "SELECT id FROM songs WHERE genre=$this->id");
        return mysqli_num_rows($query);
    }

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

}
?>