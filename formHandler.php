<?php
include("includes/config.php");
include("models/User.php");

if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
} else {
    echo "Error getting logged in user details. Please try again.";
    exit();
}

// Default redirection page
$redirect = 'browse.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Ternary operator, shorthand of if-else. Checks whether 'action' exists, after ? will execute if condition is true. After : will execute if condition is false! 
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    switch($action) {
        case 'updateEmail':
            // Input sanitization and validation
            $email = isset($_POST['email']) ? $_POST['email'] : null;
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            // Validate email
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if($userLoggedIn->updateEmail($email)) { //Success, redirect with success message
                    $_SESSION['success'] = "Email updated successfully!";
                    header("Location: $redirect");
                } else { //Failure, redirect with error message
                    $_SESSION['error'] = "Failed to update email :(";
                    header("Location: $redirect");
                }
            } else {
                header("Location: $redirect?error=Invalid email address!");
            }
            break;

        case 'updatePassword':
            $oldPassword = isset($_POST['oldPassword']) ? $_POST['oldPassword'] : null;
            $newPassword1 = isset($_POST['newPassword1']) ? $_POST['newPassword1'] : null;
            $newPassword2 = isset($_POST['newPassword2']) ? $_POST['newPassword2'] : null;

            // Simple password validation - ensure non-empty and new passwords match
            if ($oldPassword && $newPassword1 && $newPassword2 && $newPassword1 === $newPassword2) {
                if($userLoggedIn->updatePassword($oldPassword, $newPassword1, $newPassword2)) {
                    header("Location: $redirect?success=Password updated successfully!");
                } else {
                    header("Location: $redirect?error=Failed to update password :(");
                }
            } else {
                header("Location: $redirect?error=Invalid password input!");
            }
            break;

        case 'updateProfilePhoto':
            // Need to perform any necessary validation on the uploaded image file
            // Ensure file was uploaded and is the correct type, size, etc.
            if(isset($_FILES['imgupload']) && $_FILES['imgupload']['size'] > 0) {
                if($userLoggedIn->updateProfilePhoto($_FILES['imgupload'])) {
                    header("Location: $redirect?success=Profile photo updated successfully!");
                } else {
                    header("Location: $redirect?error=Failed to update profile photo :(");
                }
            } else {
                header("Location: $redirect?error=Invalid photo input!");
            }
            break;

        default:
            // Invalid action - redirect with error message
            header("Location: $redirect?error=Invalid action!");
            break;
    }
} else {
    // Invalid request method - redirect with error message
    header("Location: $redirect?error=Invalid request!");
}
