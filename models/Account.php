<?php
namespace models;

use models\Database;

	class Account {

		private $con;
		private $errorArray;

		public function __construct() {
			//Instantiate connection object and error array to hold errors
			$this->con = Database::getInstance()->getConnection();
			$this->errorArray = array();
		}

		//Login and register are public because we need to use them from outside the class, most others are private. 
		public function login($un, $pw) {
			$query = "SELECT * FROM users WHERE username = ? AND password = ?";
			$stmt = $this->con->prepare($query);
			
			$encryptedPw = md5($pw);
			
			$stmt->bind_param("ss", $un, $encryptedPw);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			if ($result->num_rows == 1) {
				$stmt->close();
				return true;
			} else {
				$stmt->close();
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		//Use Ellipsis notation to accept a variable number of parameters, aka "variadic" function parameter
		public function register(...$params) {
			// Extract parameters from the array using the list method. Makes our Register function more flexible, allow diff arguments without modifying method signature. 
			list($un, $fn, $ln, $em, $em2, $pw, $pw2) = $params;

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
			$encryptedPw = md5($pw);//Should make passwords more secure by using bcrypt or Argon2
			$profilePic = "assets/images/profile-pics/head_emerald.png";
			$date = date("Y-m-d");
		
			$query = "INSERT INTO users (username, firstName, lastName, email, password, signUpDate, profilePic, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = $this->con->prepare($query);
		
			$userLevel = 3; //Standard default User Level
		
			$stmt->bind_param("sssssssi", $un, $fn, $ln, $em, $encryptedPw, $date, $profilePic, $userLevel);
			$result = $stmt->execute();
		
			$stmt->close();
			
			return $result;
		}

		private function validateUsername($un) {
			// More than 25 or less than 5 characters, push error to the array and return to stop the function.
			if(strlen($un) > 25 || strlen($un) < 5) {
				array_push($this->errorArray, Constants::$usernameCharacters);
				return;
			}
		
			// Check if username exists in DB using a prepared statement
			$query = "SELECT username FROM users WHERE username=?";
			$stmt = $this->con->prepare($query);

			// Bind the value to the placeholder 
			$stmt->bind_param("s", $un);
			// Execute the Prepared Statement 
			$stmt->execute();
		
			// Retrieve Result Set 
			$result = $stmt->get_result();
		
			if($result->num_rows != 0) {
				array_push($this->errorArray, Constants::$usernameTaken);
				return;
			}
		
			$stmt->close();
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
				return false;
			}

			if(preg_match('/[^A-Za-z0-9]/', $pw)) {
				array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
				return false;
			}			

			if(strlen($pw) > 30 || strlen($pw) < 5) {
				array_push($this->errorArray, Constants::$passwordCharacters);
				return false;
			}

			return true;
		}

	}
?>