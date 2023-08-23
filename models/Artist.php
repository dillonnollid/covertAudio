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
		$query = mysqli_query($this->con, "SELECT * FROM artists WHERE id='$this->id'");
		return mysqli_fetch_array($query);
	}

	public function setProperties($mysqliData){
		$this->name = $mysqliData['name'];
	}

	public function getGenre(){
		return $this->genre;
	}
	
	public function getSongIds() {
		$query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist='$this->id' ORDER BY plays ASC");
		$array = array();

		while($row = mysqli_fetch_array($query)) {
			array_push($array, $row['id']);
		}
		return $array;

	}

	/* Static Methods Below */
	public static function getAllArtists() {
		$artists = array();

		// Query to get all artists from the database
		$query = mysqli_query(Database::getInstance()->getConnection(), "SELECT * FROM artists");

		while ($row = mysqli_fetch_array($query)) {
			// Create Artist objects and store them in the $artists array
			$artists[] = new Artist($row['id']);
		}

		return $artists;
	}

	public static function getArtistCount() {
		// Query to get the count of all artists from the database
		$query = mysqli_query(Database::getInstance()->getConnection(), "SELECT COUNT(id) AS artist_count FROM artists");

		// Fetch the single result value
		$row = mysqli_fetch_assoc($query);
		$artistCount = $row['artist_count'];

		return $artistCount;
	}
}
?>