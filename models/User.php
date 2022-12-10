<?php
	class User {

		private $con;
		private $username;
        private $name;
        private $profilePicture;
        private $role;

		public function __construct($con, $username) {
			$this->con = $con;
			$this->username = $username;
            $query = mysqli_query($con, "SELECT firstName, lastName, email, profilePic, role FROM users WHERE username='$this->username' LIMIT 1");
            $user = mysqli_fetch_array($query);
            $this->setUserData($user);
		}

        public function setUserData($user){
            if(isset($user[0])){
                $this->name = $user['firstName'] . " " . $user['lastName'];
                $this->profilePicture = $user['profilePic'];
                $this->role = $user['role'];
            }
        }

		public function getUsername() {
			return $this->username;
		}

        public function getName() {
            return $this->name;
        }

        public function getRoleName() {
            if($this->role==1){
                return 'super';
            } elseif($this->role==2){
                return 'admin';
            } elseif($this->role>=3){
                return 'user';
            } else {
                return false;
            }
        }

        public function getProfilePhotoPath() {
            return $this->profilePicture;
        }

        public function getFirstAndLastName() {
            $query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name'  FROM users WHERE username='$this->username'");
            $row = mysqli_fetch_array($query);
            return $row['name'];
        }

	}
?>