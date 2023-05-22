<?php
class User {
    private $con;
    private $username;
    private $userData;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
        $query = "SELECT firstName, lastName, email, profilePic, role FROM users WHERE username = ?";
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
        return true;//Temporary
    }

    public function updateProfilePhoto($imageFile){
        return true;//Temporary
    }

}

class UserRole {
    const NONE = 0;
    const SUPER = 1;
    const ADMIN = 2;
    const USER = 3;
    
}
?>
