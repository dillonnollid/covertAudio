<?php
namespace models;

use traits\QueryTrait;

class Artist extends General {
	use QueryTrait;
	private $genre;

	public function __construct($id) {
		$this->con = Database::getInstance()->getConnection();
		$this->id = $id;

		$this->mysqliData = $this->getProperties();
		$this->setProperties($this->mysqliData);
	}

	public function getProperties(){
		$query = "SELECT * FROM artists WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
		return $result->fetch_assoc();
	}

	public function setProperties($mysqliData){
		$this->name = $mysqliData['name'];
	}

	public function getGenre(){
		return $this->genre;
	}
	
	public function getSongIds() {
		//Get all song IDs, create array, iterate through query results while adding the ID's onto the array which we return! 
		$query = "SELECT id FROM songs WHERE artist=? ORDER BY plays ASC";
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("i", $this->id);
		$stmt->execute();

		$result = $stmt->get_result();
		$songIds = array();

        while ($row = $result->fetch_assoc()) {
            $songIds[] = $row['id'];
        }

        $stmt->close();

        return $songIds;
	}

	/* Static Methods Below */
	public static function getAllArtists() {
		return self::getObjectArray('artists');//Using getObjectArray() from QueryTrait
	}

	public static function getArtistCount() {
		return self::getCount('artists');
	}
}
?>