<?php
if(isset($_SESSION['userLoggedIn'])) {

} else {

}

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

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Auth - covertAudio</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="./assets/css/tailwind.output.css" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="./assets/js/init-alpine.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="assets/js/register.js"></script>
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

<div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
    <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
        <div class="flex flex-col overflow-y-auto md:flex-row">

            <div class="h-32 md:h-auto md:w-1/2">
                <img
                    aria-hidden="true"
                    class="object-cover w-full h-full dark:hidden"
                    src="./assets/images/create-account-office.jpeg"
                    alt=""
                />
                <img
                    aria-hidden="true"
                    class="hidden object-cover w-full h-full dark:block"
                    src="./assets/images/create-account-office-dark.jpeg"
                    alt=""
                />
            </div>

            <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                <!-- Register Form -->
                <form id="registerForm" action="newRegister.php" method="POST" class="w-full">
                    <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                        Create account
                    </h1>

                    <!-- Username done -->
                    <label for="username" class="block text-sm">
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                        <span class="text-gray-700 dark:text-gray-400">Username</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            id="username" name="username" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('username') ?>" required/>
                    </label>

                    <!-- First Name done -->
                    <label for="firstName" class="block text-sm">
                        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                        <span class="text-gray-700 dark:text-gray-400">First name</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            id="firstName" name="firstName" type="text" placeholder="e.g. Bart" value="<?php getInputValue('firstName') ?>" required/>
                    </label>

                    <!-- Last Name -->
                    <label for="lastName" class="block text-sm">
                        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                        <span class="text-gray-700 dark:text-gray-400">Last name</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            id="lastName" name="lastName" type="text" placeholder="e.g. Simpson" value="<?php getInputValue('lastName') ?>" required/>
                    </label>

                    <!-- Email 1 done -->
                    <label for="email" class="block text-sm">
                        <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>
                        <span class="text-gray-700 dark:text-gray-400">Email</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            id="email" name="email" type="email" placeholder="e.g. bart@gmail.com" value="<?php getInputValue('email'); ?>" required/>
                    </label>

                    <!-- Email 2 -->
                    <label for="email2" class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Email</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            id="email2" name="email2" type="email" placeholder="e.g. Same as above" value="<?php getInputValue('email2'); ?>" required/>
                    </label>

                    <!-- Password 1 done -->
                    <label for="password" class="block mt-4 text-sm">
                        <?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
                        <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                        <?php echo $account->getError(Constants::$passwordCharacters); ?>
                        <span class="text-gray-700 dark:text-gray-400">Password</span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            id="password" name="password" type="password" placeholder="Your password" required
                        />
                    </label>

                    <!-- Password 2 done -->
                    <label for="password2" class="block mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">
                          Confirm password
                        </span>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            id="password2" name="password2" type="password" placeholder="Repeat your password" required
                        />
                    </label>

                    <div class="flex mt-6 text-sm">
                        <label class="flex items-center dark:text-gray-400">
                            <input
                                type="checkbox"
                                class="text-blue-600 form-checkbox focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray"
                            />
                            <span class="ml-2">
                                I agree to the <span class="underline">privacy policy</span>
                            </span>
                        </label>
                    </div>

                    <hr class="my-8" />

                    <button type="submit" name="registerButton" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        Create account
                    </button>

                    <!-- Switch to login form-->
                    <p class="mt-4 hasAccountText">
                        <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" id="hideRegister">
                            Already have an account? Login
                        </a>
                    </p>
                </form>

                <!-- INSERT LOGIN FORM HERE -->
                <form id="loginForm" action="newRegister.php" method="POST" class="w-full">
                    <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">Login to your account</h1>
                    <p>
                        <!-- These errors will only print if they exist obviously, getError checks if the error exists in our log array, if it exists in the array then it returns the error text!  -->
                        <?php echo $account->getError(Constants::$loginFailed); ?>
                        <label for="loginUsername" class="block text-sm text-gray-700 dark:text-gray-400" >Username</label>
                        <input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('loginUsername') ?>" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required>
                    </p>
                    <br>
                    <p>
                        <label for="loginPassword" class="block text-sm text-gray-700 dark:text-gray-400">Password</label>
                        <input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" required>
                    </p>

                    <hr class="my-8" />

                    <button type="submit" name="loginButton" class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                        Log In
                    </button>

                    <br>

                    <div class="hasAccountText" >
                        <span id="hideLogin" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
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

