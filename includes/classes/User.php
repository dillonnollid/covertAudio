<?php
	class User {

		private $con;
		private $username;
        private $profilePicture;

		public function __construct($con, $username) {
			$this->con = $con;
			$this->username = $username;
            $this->profilePicture = "./assets/images/profile-pics/head_emerald.png";
		}

		public function getUsername() {
			return $this->username;
		}

		public function getFirstAndLastName() {
			$query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name'  FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['name'];
		}

        public function getProfilePhotoPath() {
            return $this->profilePicture;
        }

	}
?>