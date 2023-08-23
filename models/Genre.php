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
        $query = "SELECT * FROM genres WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
		return $result->fetch_assoc();
    }

    public function setProperties($mysqliData){
        $this->name = $mysqliData['name'];
    }

    public function getMysqliData() {
        return $this->mysqliData;
    }

    public function getGenreSongCount() {
        $query = "SELECT COUNT(id) AS songCount FROM songs WHERE genre = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $songCount = $row['songCount'];
        $stmt->close();

        return $songCount;
    }

    /* Static Methods Below */
    public static function getGenreObjects() {
        $genres = array();

        // Query to get all genres from the database
        $query = "SELECT * FROM genres ORDER BY id ASC";
		$stmt = Database::getInstance()->getConnection()->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            // Create Genre objects and store them in the $genres array
			$genres[] = new Genre($row['id']);
        }

        $stmt->close();

		return $genres;
    }

    public static function getGenreCount() {
        // Query to get the count of all artists from the database
        $query = "SELECT COUNT(id) AS genreCount FROM genres";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the single result value
        $row = $result->fetch_assoc();
        $albumCount = $row['genreCount'];
        $stmt->close();

        return $albumCount;
    }

}
?>