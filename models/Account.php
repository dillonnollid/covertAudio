<?php
	class Account {

		private $con;
		private $errorArray;

		public function __construct($con) {
			//Instantiate connection object and error array to hold errors
			$this->con = $con;
			$this->errorArray = array();
		}

		//Login and register are public because we need to use them from outside the class, most others are private. 
		public function login($un, $pw) {
			$pw = md5($pw);
			$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

			if(mysqli_num_rows($query) == 1) {
				return true;
			} else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
			//this instance of the class call this function
			$this->validateUsername($un);
			$this->validateFirstName($fn);
			$this->validateLastName($ln);
			$this->validateEmails($em, $em2);
			$this->validatePasswords($pw, $pw2);

			if(empty($this->errorArray) == true) {
				//Insert into db
				return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
			}
			else {
				return false;
			}
		}

		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		private function insertUserDetails($un, $fn, $ln, $em, $pw) {
			//md5 simple encryption, pass in password, it returns hashed key kinda. Set variables and insert to db, return result
			$encryptedPw = md5($pw);
			$profilePic = "assets/images/profile-pics/head_emerald.png";
			$date = date("Y-m-d");

			$result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$un', '$fn', '$ln','$em','$encryptedPw','$date','$profilePic',3)");
			return $result;
		}

		private function validateUsername($un) {
			//more than 25 or less than 5, push error to the array and return to stop the funk. We can use constants because we included them before we used the Account class
			if(strlen($un) > 25 || strlen($un) < 5) {
				array_push($this->errorArray, Constants::$usernameCharacters);
				return;
			}
			//Check if username exists in DB, 
			$checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
			if(mysqli_num_rows($checkUsernameQuery) != 0) {
				array_push($this->errorArray, Constants::$usernameTaken);
				return;
			}
		}

		private function validateFirstName($fn) {
			if(strlen($fn) > 25 || strlen($fn) < 2) {
				array_push($this->errorArray, Constants::$firstNameCharacters);
				return;
			}
		}

		private function validateLastName($ln) {
			if(strlen($ln) > 25 || strlen($ln) < 2) {
				array_push($this->errorArray, Constants::$lastNameCharacters);
				return;
			}
		}

		public function validateEmails($em, $em2) {
			//Sanitize email variables
			$em = $this->con->real_escape_string($em);
			$em2 = $this->con->real_escape_string($em2);
			
			//Check emails and ensure both entries are matching
			if($em != $em2) {
				array_push($this->errorArray, Constants::$emailsDoNotMatch);
				return;
			}

			//Validate email address
			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}

			$checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
			if(mysqli_num_rows($checkEmailQuery) != 0) {
				array_push($this->errorArray, Constants::$emailTaken);
				return;
			}
		}

		public function validatePasswords($pw, $pw2) {
			if($pw != $pw2) {
				array_push($this->errorArray, Constants::$passwordsDoNoMatch);
				return;
			}

			if(preg_match('/[^A-Za-z0-9]/', $pw)) {
				array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
				return;
			}

			if(strlen($pw) > 30 || strlen($pw) < 5) {
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
			}
		}

	}
?>