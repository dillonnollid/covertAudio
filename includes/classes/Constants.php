<?php
class Constants {
	//don't need to create instance of class, use these bad boys anywhere! use Constants::$passwordsDoNoMatch if it's been included.
	//use -> when we have an instance of the class, use :: when we aren't instantiating the class! 
	public static $passwordsDoNoMatch = "Passwords don't match";
	public static $passwordNotAlphanumeric = "Password can only contain numbers and letters";
	public static $passwordCharacters = "Password must be between 5 and 30 characters";
	public static $emailInvalid = "Email is invalid";
	public static $emailsDoNotMatch = "Email addresses don't match";
	public static $emailTaken = "Email address is already in use";
	public static $lastNameCharacters = "Last name must be between 2 and 25 characters";
	public static $firstNameCharacters = "First name must be between 2 and 25 characters";
	public static $usernameCharacters = "Username must be between 5 and 25 characters";
	public static $usernameTaken = "This username already exists";
	public static $loginFailed = "Username or password was incorrect";
}
?>