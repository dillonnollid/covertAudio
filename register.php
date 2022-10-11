<?php
	//config connects us to the database. Gives us a $con object including the connection. Connection is required to create Account object like shown below! Constants does exactly what it says on the tin, just contains our String constants.  
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	//We need the request and login handlers to use their functions, basically pasting the code onto my page.
	//above we include some object classes, but the handlers also interact with these Object Classes. 
	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>Auth - covertAudio</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/tailwind.output.css"/>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="assets/js/init-alpine.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- JS, we use JQuery in our very simple register.js file. -->
	<!--<script src="assets/js/register.js"></script>-->
</head>
<body>
	<?php
	//Determines what script we wanna load, if register button not hit then we wanna show login form rather than register
	if(isset($_POST['registerButton'])) {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").hide();
					$("#registerForm").show();
				});
			</script>';
	} else {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").show();
					$("#registerForm").hide();
				});
			</script>';
	}
	?>

	<div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900" id="background" >
		<div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800" id="loginContainer">
			<div id="inputContainer" class="flex flex-col overflow-y-auto md:flex-row">

                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <!-- Separate forms for login or register, Jquery used to show and hide the appropriate forms-->
                    <form id="loginForm" action="register.php" method="POST" class="flex flex-col overflow-y-auto md:flex-row">
                        <div class="h-32 md:h-auto md:w-1/2">
                            <h2>Login to your account</h2>
                            <p>
                                <!-- These errors will only print if they exist obviously, getError checks if the error exists in our log array, if it exists in the array then it returns the error text!  -->
                                <?php echo $account->getError(Constants::$loginFailed); ?>
                                <label for="loginUsername">Username</label>
                                <input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('loginUsername') ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required>
                            </p>
                            <p>
                                <label for="loginPassword">Password</label>
                                <input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required>
                            </p>

                            <button type="submit" name="loginButton">LOG IN</button>

                            <div class="hasAccountText">
                                <span id="hideLogin">Don't have an account yet? Signup here.</span>
                            </div>
                        </div>
                    </form>

                    <form id="registerForm" action="register.php" method="POST">
                        <h2>Create account</h2>
                        <p>
                            <?php echo $account->getError(Constants::$usernameCharacters); ?>
                            <?php echo $account->getError(Constants::$usernameTaken); ?>
                            <label for="username">Usernameeee</label>
                            <input id="username" name="username" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('username') ?>" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                            <label for="firstName">First nameeeee</label>
                            <input id="firstName" name="firstName" type="text" placeholder="e.g. Bart" value="<?php getInputValue('firstName') ?>" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                            <label for="lastName">Last nameeeeee</label>
                            <input id="lastName" name="lastName" type="text" placeholder="e.g. Simpson" value="<?php getInputValue('lastName') ?>" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                            <?php echo $account->getError(Constants::$emailInvalid); ?>
                            <?php echo $account->getError(Constants::$emailTaken); ?>
                            <label for="email">Email!</label>
                            <input id="email" name="email" type="email" placeholder="e.g. bart@gmail.com" value="<?php getInputValue('email') ?>" required>
                        </p>

                        <p>
                            <label for="email2">Confirm email!</label>
                            <input id="email2" name="email2" type="email" placeholder="e.g. bart@gmail.com" value="<?php getInputValue('email2') ?>" required>
                        </p>

                        <p>
                            <?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
                            <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                            <?php echo $account->getError(Constants::$passwordCharacters); ?>
                            <label for="password">Password?</label>
                            <input id="password" name="password" type="password" placeholder="Your password" required>
                        </p>

                        <p>
                            <label for="password2">Confirm password?</label>
                            <input id="password2" name="password2" type="password" placeholder="Your password" required>
                        </p>

                        <p>
                            <label for="password3">Secret Phrase(not working yet but you need this to sign up)</label>
                            <input id="password3" name="password3" type="password" placeholder="Type the secret here, must be exact" required>
                        </p>

                        <button type="submit" name="registerButton">SIGN UP</button>

                        <div class="hasAccountText">
                            <span id="hideRegister">Already have an account? Click here to Log in.</span>
                        </div>
                    </form>
                </div>
			</div>

		</div>
	</div>
</body>
</html>