<?php
    //config connects us to the database. Gives us a $con object including the connection. Connection is required to create Account object like shown below! Constants does exactly what it says on the tin, just contains our String constants.
    include("includes/config.php");
    include("models/Account.php");
    include("models/Constants.php");

    $account = new Account($con);

    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");

    function getInputValue($name) {
        if(isset($_POST[$name])) {
            echo $_POST[$name];
        }
    }
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>covertAuth</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="./assets/js/register.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script src="./assets/js/init-alpine.js" defer></script>
</head>

<body x-data="data()" x-init="$watch('dark', value => document.documentElement.classList.toggle('dark', value))" class="bg-gradient-to-r from-gray-900 to-purple-900 animate-gradient-x antialiased">

<?php
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

<div class="authPage">
    <div class="authContainer">
        <div class="authInner">

            <div class="authImageContainer">
                <img
                    aria-hidden="true"
                    class="object-cover w-full h-full dark:hidden"
                    src="./assets/images/wave.jpeg"
                    alt=""
                />
                <img
                    aria-hidden="true"
                    class="hidden object-cover w-full h-full dark:block"
                    src="./assets/images/ufo.jpeg"
                    alt=""
                />
            </div>

            <div class="formContainer">

                <!-- Register Form -->
                <form id="registerForm" action="register.php" method="POST" class="w-full">
                    <h1 class="logo">
                        covertAuth - Register
                    </h1>

                    <!-- Username -->
                    <label for="username" class="labelStyle">
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$usernameCharacters);?>
                        </span>
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$usernameTaken);?>
                        </span>
                        <span class="labelText">Username</span>
                        <input
                            class="generalInput"
                            id="username" name="username" type="text" placeholder="e.g. johnSmith" value="<?php getInputValue('username') ?>" required/>
                    </label>

                    <!-- First Name -->
                    <label for="firstName" class="labelStyle">
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$firstNameCharacters);?>
                        </span>
                        <span class="labelText">First name</span>
                        <input
                            class="generalInput"
                            id="firstName" name="firstName" type="text" placeholder="e.g. John" value="<?php getInputValue('firstName') ?>" required/>
                    </label>

                    <!-- Last Name -->
                    <label for="lastName" class="labelStyle">
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$lastNameCharacters);?>
                        </span>
                        <span class="labelText">Last name</span>
                        <input
                            class="generalInput"
                            id="lastName" name="lastName" type="text" placeholder="e.g. Smith" value="<?php getInputValue('lastName') ?>" required/>
                    </label>

                    <!-- Email 1 -->
                    <label for="email" class="labelStyle">
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$emailsDoNotMatch);?>
                        </span>
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$emailInvalid);?>
                        </span>
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$emailTaken);?>
                        </span>
                        <span class="labelText">Email</span>
                        <input
                            class="generalInput"
                            id="email" name="email" type="email" placeholder="e.g. john@gmail.com" value="<?php getInputValue('email'); ?>" required/>
                    </label>

                    <!-- Repeat Email -->
                    <label for="email2" class="labelStyle">
                        <span class="labelText">Repeat Email</span>
                        <input
                            class="generalInput"
                            id="email2" name="email2" type="email" placeholder="e.g. Same as above" value="<?php getInputValue('email2'); ?>" required/>
                    </label>

                    <!-- Password -->
                    <label for="password" class="labelStyle">
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$passwordsDoNoMatch);?>
                        </span>
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$passwordNotAlphanumeric);?>
                        </span>
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$passwordCharacters);?>
                        </span>
                        <span class="labelText">Password</span>
                        <input
                            class="generalInput"
                            id="password" name="password" type="password" placeholder="Your password" required
                        />
                    </label>
                    <!-- Repeat Password -->
                    <label for="password2" class="labelStyle">
                        <span class="labelText">
                          Confirm password
                        </span>
                        <input
                            class="generalInput"
                            id="password2" name="password2" type="password" placeholder="Repeat your password" required
                        />
                    </label>

                    <!-- Privacy Policy -->
                    <div class="flex mt-6 text-sm">
                        <label class="labelText flex items-center">
                            <input
                                type="checkbox"
                                class="checkBox"
                            />
                            <span class="ml-2">
                                I agree to the <span class="underline">privacy policy</span>
                            </span>
                        </label>
                    </div>

                    <hr class="my-8">

                    <button type="submit" name="registerButton" class="submitButton">
                        Create account
                    </button>

                    <!-- Switch to Login form-->
                    <p class="mt-4 hasAccountText">
                        <a class="themedText" id="hideRegister">
                            Already have an account? Click here!
                        </a>
                    </p>
                </form>

                <!-- Login Form -->
                <form id="loginForm" action="register.php" method="POST" class="w-full">
                    <h1 class="logo">covertAuth - Login</h1>
                    <p>
                        <!-- These errors will only print if they exist obviously, getError checks if the error exists in our log array, if it exists in the array then it returns the error text! -->
                        <span class="errorText">
                            <?php echo $account->getError(Constants::$loginFailed);?>
                        </span>
                        <label for="loginUsername" class="labelStyle labelText">Username</label>
                        <input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. johnSmith" value="<?php getInputValue('loginUsername') ?>" class="generalInput" required>
                    </p>
                    <br>
                    <p>
                        <label for="loginPassword" class="labelStyle labelText">Password</label>
                        <input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" class="generalInput" required>
                    </p>

                    <hr class="my-8">

                    <button type="submit" name="loginButton" class="submitButton">
                        Log In
                    </button>

                    <br>

                    <div class="hasAccountText">
                        <span id="hideLogin" class="themedText">
                            Don't have an account yet? Signup here.
                        </span>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</body>
</html>

