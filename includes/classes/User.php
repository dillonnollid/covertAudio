<?php
	class User {

		private $con;
		private $username;
        private $name;
        private $profilePicture;

		public function __construct($con, $username) {
			$this->con = $con;
			$this->username = $username;
            $query = mysqli_query($this->con, "SELECT firstName, lastName, email, profilePic FROM users WHERE username='$this->username' LIMIT 1");
            $user = mysqli_fetch_array($query);
            $this->name = $user['firstName'] . " " . $user['lastName'];
            $this->profilePicture = $user['profilePic'];//$this->getProfilePhotoPath();//"./assets/images/profile-pics/head_emerald.png";
            echo "<br>";//$this->profilePicture;
            //LIGHT MODE WORKS WHEN I ECHO SOMETHING HERE LOL
		}

		public function getUsername() {
			return $this->username;
		}

        public function getName() {
            return $this->name;
        }

		public function getFirstAndLastName() {
			$query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name'  FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['name'];
		}

        public function getProfilePhotoPath() {
            //$query = mysqli_query($this->con, "SELECT profilePic as 'pic'  FROM users WHERE username='$this->username'");
            //$row = mysqli_fetch_array($query);
            //return "" . $row['pic'];
            return $this->profilePicture;
        }

	}
?>