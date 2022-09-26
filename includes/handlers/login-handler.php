<?php
if(isset($_POST['loginButton'])) {
	//Login button was pressed, get the username and pass from POST after click
	$username = $_POST['loginUsername'];
	$password = $_POST['loginPassword'];

	//call the login method belonging to our account object, if it's a success we set a variable and redirect to home. 
	$result = $account->login($username, $password);

	if($result == true) {
		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}

}
?>