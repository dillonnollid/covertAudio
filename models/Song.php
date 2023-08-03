<?php
namespace models;

use models\Database;

	class Song {

		private $con;
		private $id;
		private $mysqliData;
		private $title;
		private $artistId;
		private $albumId;
		private $genre;
		private $duration;
		private $path;

		public function __construct($id) {
			$this->con = Database::getInstance()->getConnection();
			$this->id = $id;

			//Query on creation, store data in myslqiData array and assign the vars values
			$query = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
			$this->mysqliData = mysqli_fetch_array($query);
			$this->title = $this->mysqliData['title'];
			$this->artistId = $this->mysqliData['artist'];
			$this->albumId = $this->mysqliData['album'];
			$this->genre = $this->mysqliData['genre'];
			$this->duration = $this->mysqliData['duration'];
			$this->path = $this->mysqliData['path'];
		}

		public function getTitle() {
			return $this->title;
		}

		public function getId() {
			return $this->id;
		}

		public function getArtist() {
			return new Artist($this->artistId);
		}

		public function getAlbum() {
			return new Album($this->albumId);
		}

        public function getGenre() {
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