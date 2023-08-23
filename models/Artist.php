<?php
namespace models;

class Artist extends General {
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
		$artists = array();
		// Query to get all artists from the database
		$query = "SELECT * FROM artists ORDER BY id ASC";
		$stmt = Database::getInstance()->getConnection()->prepare($query);
		$stmt->execute();

		$result = $stmt->get_result();

		while ($row = $result->fetch_assoc()) {
            // Create Album objects and store them in the $albums array
			$artists[] = new Artist($row['id']);
        }

        $stmt->close();

		return $artists;
	}

	public static function getArtistCount() {
		// Query to get the count of all artists from the database
		$query = "SELECT COUNT(id) AS artistCount FROM artists";
        $stmt = Database::getInstance()->getConnection()->prepare($query);
        $stmt->execute();
		$result = $stmt->get_result();

		// Fetch the single result value
		$row = $result->fetch_assoc();
        $artistCount = $row['artistCount'];
        $stmt->close();

        return $artistCount;
	}
}
?>