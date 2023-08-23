<?php
namespace models;

class Song extends General {
	private $artistId;
	private $albumId;
	private $genre;
	private $duration;
	private $path;

	public function __construct($id) {
		$this->con = Database::getInstance()->getConnection();
		$this->id = $id;

		$this->mysqliData = $this->getProperties();
		$this->setProperties($this->mysqliData);
	}

	public function getProperties(){
		$query = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
		return mysqli_fetch_array($query);
	}

	public function setProperties($mysqliData){
		$this->name = $this->mysqliData['title'];
		$this->artistId = $this->mysqliData['artist'];
		$this->albumId = $this->mysqliData['album'];
		$this->genre = $this->mysqliData['genre'];
		$this->duration = $this->mysqliData['duration'];
		$this->path = $this->mysqliData['path'];
	}

	public function getArtist(): Artist {
		return new Artist($this->artistId);
	}

	public function getAlbum(): Album {
		return new Album($this->albumId);
	}

	public function getGenre(): Genre {
		return new Genre($this->genre);
	}

	public function getPath() {
		return $this->path;
	}

	public function getDuration() {
		return $this->duration;
	}

	public function getMysqliData() {
		return $this->mysqliData;
	}


	/* Static Methods Below */
	public static function getAllSongs() {
		$songs = array();

		// Query to get all songs from the database
		$query = mysqli_query(Database::getInstance()->getConnection(), "SELECT * FROM songs");

		while ($row = mysqli_fetch_array($query)) {
			// Create Song objects and store them in the $songs array
			$songs[] = new Song($row['id']);
		}

		return $songs;
	}

	public static function getSongCount() {
		// Query to get the count of all songs from the database
		$query = mysqli_query(Database::getInstance()->getConnection(), "SELECT COUNT(id) AS songCount FROM songs");

		// Fetch the single result value
		$row = mysqli_fetch_assoc($query);
		$songCount = $row['songCount'];

		return $songCount;
	}

}
?>