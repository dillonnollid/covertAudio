<?php
namespace models;

use traits\QueryTrait;

class Genre extends General {
    use QueryTrait;

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
        return self::getObjectArray('genres');//Using getObjectArray() from QueryTrait
    }

    public static function getGenreCount() {
        return self::getCount('genres');
    }

}
?>