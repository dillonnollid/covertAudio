<?php
namespace models;

use traits\QueryTrait;

class Album extends General {
	use QueryTrait;
	private $artistId;
	private $genre;
	private $artworkPath;

	public function __construct($id) {
		$this->con = Database::getInstance()->getConnection();
		$this->id = $id;

		$this->mysqliData = $this->getProperties();
		$this->setProperties($this->mysqliData);
	}

	public function getProperties(){
		$query = "SELECT * FROM albums WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
		return $result->fetch_assoc();
	}

	public function setProperties($mysqliData){
		$this->name = $mysqliData['title'];
		$this->artistId = $mysqliData['artist'];
		$this->genre = $mysqliData['genre'];
		$this->artworkPath = $mysqliData['artworkPath'];
	}

	public function getArtist(): Artist {
		return new Artist($this->artistId);
	}

	public function getGenre() {
		return $this->genre;
	}

	public function getArtworkPath() {
		return $this->artworkPath;
	}

	public function getNumberOfSongs() {
		$query = "SELECT COUNT(id) AS songCount FROM songs WHERE album = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $songCount = $row['songCount'];
        $stmt->close();

        return $songCount;
	}

	public function getSongIds() {
		//Get all song IDs, create array, iterate through query results while adding the ID's onto the array which we return! 
		$query = "SELECT id FROM songs WHERE album=? ORDER BY albumOrder ASC";
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
	public static function getAllAlbums() {
		return self::getObjectArray('albums');//Using getObjectArray() from QueryTrait
	}

	public static function getAlbumCount() {
		return self::getCount('albums');
	}
}
?>