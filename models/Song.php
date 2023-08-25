<?php
namespace models;
use traits\QueryTrait;

class Song extends General {
	use QueryTrait;
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
		$query = "SELECT * FROM songs WHERE id = ?";
        
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
		return $result->fetch_assoc();
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
		return self::getObjectArray('songs');//Using getObjectArray() from QueryTrait
	}

	public static function getSongCount() {
		return self::getCount('songs');//Using getCount() from QueryTrait
	}

}
?>