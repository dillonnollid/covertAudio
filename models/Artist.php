<?php
	class Artist {

		private $con;
		private $id;
        private $genre;

		public function __construct($con, $id) {
			$this->con = $con;
			$this->id = $id;
		}

		public function getId() {
			return $this->id;
		}

		public function getName() {
			$artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id='$this->id'");
			$artist = mysqli_fetch_array($artistQuery);
			return $artist['name'];
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

		public static function getAllArtists($con) {
			$artists = array();
	
			// Query to get all artists from the database
			$query = mysqli_query($con, "SELECT * FROM artists");
	
			while ($row = mysqli_fetch_array($query)) {
				// Create Artist objects and store them in the $artists array
				$artists[] = new Artist($con, $row['id']);
			}
	
			return $artists;
		}
	}
?>