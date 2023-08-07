<?php
namespace models;

use models\Database;
use models\User;

class Playlist {

		private $con;
		private $id;
		private $name;
		private $owner;
        private $created;

		public function __construct($id) {
			$this->con = Database::getInstance()->getConnection();
			$this->id = $id;

            $query = mysqli_query($this->con, "SELECT * FROM playlists WHERE id='$this->id'");
            $data = mysqli_fetch_array($query);

            $this->name = $data['name'];
            $this->owner = $data['owner'];
            $this->created = $data['dateCreated'];

		}

		public function getId() {
			return $this->id;
		}

		public function getName() {
			return $this->name;
		}

		public function getOwner() {
			return $this->owner;
		}

        public function getCreated() {
            return $this->created;
        }

		public function getNumberOfSongs() {
			$query = mysqli_query($this->con, "SELECT songId FROM playlistSongs WHERE playlistId='$this->id'");
			return mysqli_num_rows($query);
		}

		public function getSongIds() {
			$query = mysqli_query($this->con, "SELECT songId FROM playlistSongs WHERE playlistId='$this->id' ORDER BY playlistOrder ASC");
			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['songId']);
			}
			return $array;
		}

		public static function getPlaylistsDropdown($username) {
			$dropdown = '<select class="item playlist"><option value="">Add to playlist</option>';

			$query = mysqli_query(Database::getInstance()->getConnection(), "SELECT id, name FROM playlists WHERE owner='$username'");
			while($row = mysqli_fetch_array($query)) {
				$id = $row['id'];
				$name = $row['name'];

				$dropdown = $dropdown . "<option value='$id'>$name</option>";
			}

			return $dropdown . "</select>";
		}

        public function getPlaylistSongs(){
            $query = mysqli_query($this->con, "SELECT * FROM playlistSongs WHERE playlistId='$this->id' ORDER BY playlistOrder ASC");
            $array = array();

            while($row = mysqli_fetch_array($query)) {
                array_push($array, $row['songId']);
            }
            return $array;
        }

        public static function getUserPlaylists(){
            $query = mysqli_query(Database::getInstance()->getConnection(), "SELECT * FROM playlists WHERE owner='" . $_SESSION["userLoggedIn"] . "' ORDER BY id ASC");
            $array = array();

            while($row = mysqli_fetch_array($query)) {
                array_push($array, $row);
            }
            return $array;
        }

	}
?>