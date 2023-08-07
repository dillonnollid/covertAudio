<?php
namespace models;

use models\Database;
use models\Account;

class User {
    private $con;
    private $username;
    private $userData;
    private $account;

    public function __construct($username) {
        $this->con = Database::getInstance()->getConnection();
        $this->username = $username;
        $this->account = new Account();
        $query = "SELECT id, firstName, lastName, email, profilePic, role FROM users WHERE username = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->userData = $result->fetch_assoc();
        $stmt->close();
    }

    public function getUsername() {
        return $this->username;
    }

    public function getId() {
        return $this->userData['id'];
    }

    public function getEmail() {
        return $this->userData['email'];
    }

    public function getName() {
        return $this->userData['firstName'] . ' ' . $this->userData['lastName'];
    }

    public function getProfilePhotoPath() {
        return $this->userData['profilePic'];
    }

    public function getRole() {
        return $this->userData['role'];
    }

    public function getRoleName() {
        switch ($this->getRole()) {
            case UserRole::SUPER:
                return 'SuperUser';
            case UserRole::ADMIN:
                return 'Administrator';
            case UserRole::USER:
                return 'User';
            default:
                return 'None';
        }
    }

    public static function getUserCount() {
        // Query to get the count of all users from the database
        $query = mysqli_query(Database::getInstance()->getConnection(), "SELECT COUNT(id) AS userCount FROM users");

        // Fetch the single result value
        $row = mysqli_fetch_assoc($query);
        $userCount = $row['userCount'];

        return $userCount;
    }

    public function updateEmail($newEmail){
        // Sanitize email input to protect against SQL injection
        $newEmail = $this->con->real_escape_string($newEmail);

        //If email doesn't exist, proceed and execute SQL update
        $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$newEmail'");
        if(mysqli_num_rows($checkEmailQuery) == 0) {
            // SQL query to update the email address
            $sql = "UPDATE users SET email = '$newEmail' WHERE username = '$this->username'";
        
            // Perform the update        
            if($this->con->query($sql)){
                return true;
            } else {
                return false;
            }
        } else { 
            // Email already exists
            return false;
        }
        
    }

    public function updatePassword($oldPassword, $newPassword1, $newPassword2){
        // Sanitize passwords to protect against SQL injection
        $oldPassword    = $this->con->real_escape_string($oldPassword);
        $newPassword1   = $this->con->real_escape_string($newPassword1);
        $newPassword2   = $this->con->real_escape_string($newPassword2);
        
        if($this->account->login($this->username, $oldPassword) && $this->account->validatePasswords($newPassword1, $newPassword2)){
            //Old password is correct, encrypt and update new password
            $encryptedPw = md5($newPassword1);

            $sql = "UPDATE users SET password = '$encryptedPw' WHERE username = '$this->username'";
        
            // Perform the update and return the result
            if($this->con->query($sql)){
                return true;
            } else {
                return false;
            }   
            
        } else {
            //Old password is incorrect
            return false;
        }
    }

    public function updateProfilePhoto($imageFile){
        // Check if file was uploaded without errors
        if(isset($imageFile) && $imageFile['error'] == 0){
            $valid_extensions = array("jpg", "jpeg", "png", "gif"); // Define valid file extensions
    
            $file_extension = pathinfo($imageFile["name"], PATHINFO_EXTENSION); // Extract the file extension
    
            if(in_array($file_extension, $valid_extensions)){ // Check if file extension is valid
                $new_file_name = $this->username . "_" . time() . "." . $file_extension; // Generate unique file name to avoid overwriting other files

                $file_path = __DIR__ . "/../assets/images/profile-pics/" . $new_file_name;

                if(move_uploaded_file($imageFile["tmp_name"], $file_path)){ // Move the file to the server
                    // Update the profile photo in the database
                    $sql = "UPDATE users SET profilePic = 'assets/images/profile-pics/$new_file_name' WHERE username = '$this->username'";
    
                    if($this->con->query($sql)){
                        return true;
                    } else {
                        return false;
                    }
                } else { // Failed to move file
                    return false;
                }
            } else { // Invalid file extension
                return false;
            }
        } else { // File not uploaded or other error occurred
            return false;
        }
    }
    

}

class UserRole {
    const NONE = 0;
    const SUPER = 1;
    const ADMIN = 2;
    const USER = 3;
    
}
?>
