<?php
namespace models;

use models\Database;
use models\User;

use traits\QueryTrait;

class Playlist extends General {
		private $owner;
        private $created;

		public function __construct($id) {
			$this->con = Database::getInstance()->getConnection();
			$this->id = $id;

			$this->mysqliData = $this->getProperties();
			$this->setProperties($this->mysqliData);
		}

		public function getProperties(){
			$query = "SELECT * FROM playlists WHERE id = ?";
			
			$stmt = $this->con->prepare($query);
			$stmt->bind_param("i", $this->id);
			$stmt->execute();
			$result = $stmt->get_result();
			return $result->fetch_assoc();
		}

		public function setProperties($mysqliData){
			$this->name = $mysqliData['name'];
            $this->owner = $mysqliData['owner'];
            $this->created = $mysqliData['dateCreated'];
		}

		public function getOwner() {
			return $this->owner;
		}

        public function getCreated() {
            return $this->created;
        }

		public function getNumberOfSongs() {
			$query = "SELECT COUNT(songId) AS songCount FROM playlistSongs WHERE playlistId = ?";
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
			$query = "SELECT songId FROM playlistSongs WHERE playlistId=? ORDER BY playlistOrder ASC";
			$stmt = $this->con->prepare($query);
			$stmt->bind_param("i", $this->id);
			$stmt->execute();

			$result = $stmt->get_result();
			$songIds = array();

			while ($row = $result->fetch_assoc()) {
				$songIds[] = $row['songId'];
			}

			$stmt->close();

			return $songIds;
		}

		public static function getPlaylistsDropdown($username) {
			$dropdown = '<select class="item playlist"><option value="">Add to playlist</option>';
		
			$query = "SELECT id, name FROM playlists WHERE owner=?";
			$stmt = Database::getInstance()->getConnection()->prepare($query);
			$stmt->bind_param("s", $username);
			$stmt->execute();
		
			$result = $stmt->get_result();
		
			while($row = $result->fetch_assoc()) {
				$id = $row['id'];
				$name = $row['name'];
		
				$dropdown .= "<option value='$id'>$name</option>";
			}
		
			$stmt->close();
		
			return $dropdown . "</select>";
		}		

        public static function getUserPlaylists(){
			$username = $_SESSION["userLoggedIn"];
			$query = "SELECT * FROM playlists WHERE owner=? ORDER BY id ASC";
			$stmt = Database::getInstance()->getConnection()->prepare($query);
			$stmt->bind_param("s", $username);
			$stmt->execute();
		
			$result = $stmt->get_result();
			$array = array();
		
			while($row = $result->fetch_assoc()) {
				array_push($array, $row);
			}
		
			$stmt->close();
		
			return $array;
		}		

	}
?>