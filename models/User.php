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

}

class UserRole {
    const NONE = 0;
    const SUPER = 1;
    const ADMIN = 2;
    const USER = 3;
    
}
?>
