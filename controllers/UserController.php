<?php
namespace controllers;

use models\User;
use models\Account;

class UserController {

    public function __construct(){

    }

    public function getTotalUserCount() {
        return User::getUserCount();
    }
}
?>
