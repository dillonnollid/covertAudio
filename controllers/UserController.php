<?php
namespace controllers;

use models\User;
use models\Account;

class UserController {

    // Private static property to hold the instance
    private static $instance;

    // Private constructor to prevent direct instantiation
    private function __construct(){
        // Add any initialization logic here
    }

    // Static method to get the instance
    public static function getInstance() {
        // Check if the instance exists, if not, create it
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getTotalUserCount() {
        return User::getUserCount();
    }

}
?>
