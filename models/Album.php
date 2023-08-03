<?php
namespace models;

use models\Database;
	class Album {

		private $con;
		private $id;
		private $title;
		private $artistId;
		private $genre;
		private $artworkPath;

		//Constructor gets the Album info from a DB query, sets vars so we can use them in any function. 
		public function __construct($id) {
			$this->con = Database::getInstance()->getConnection();
			$this->id = $id;

			$query = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
			$album = mysqli_fetch_array($query);

			$this->title = $album['title'];
			$this->artistId = $album['artist'];
			$this->genre = $album['genre'];
			$this->artworkPath = $album['artworkPath'];

		}

		public function getTitle() {
			return $this->title;
		}

		public function getArtist() {
			return new Artist($this->artistId);
		}

		public function getGenre() {
			return $this->genre;
		}

        public function getID(){
            return $this->id;
        }

		public function getArtworkPath() {
			return $this->artworkPath;
		}

		public function getNumberOfSongs() {
			//Should replace this with a mysql count statement instead of using num_rows function.
			$query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id'");
			return mysqli_num_rows($query);
		}

		public function getSongIds() {
			//Get all song IDs, create array, iterate through query results while adding the ID's onto the array which we return! 
			$query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC");
			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['id']);
			}
			return $array;
		}

		public static function getAllAlbums() {
			$albums = array();
	
			// Query to get all genres from the database
			$query = mysqli_query(Database::getInstance()->getConnection(), "SELECT * FROM albums");
	
			while ($row = mysqli_fetch_array($query)) {
				// Create Album objects and store them in the $albums array
				$albums[] = new Album($row['id']);
			}
	
			return $albums;
		}

        public static function getAlbumCount() {
            // Query to get the count of all albums from the database
            $query = mysqli_query(Database::getInstance()->getConnection(), "SELECT COUNT(id) AS album_count FROM albums");

            // Fetch the single result value
            $row = mysqli_fetch_assoc($query);
            $albumCount = $row['album_count'];

            return $albumCount;
        }

	}
?>