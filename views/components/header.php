<?php
use models\User;
// Get the current script filename
$currentFile = $_SERVER['PHP_SELF'];

// Check if the requested file or directory doesn't exist
if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $currentFile)) {
    header('Location: /index.php');//Redirect to home page
    exit(); //exit after sending the redirect header
}

include("includes/config.php");
include("models/User.php");
include("models/Artist.php");
include("models/Album.php");
include("models/Song.php");

//If user's not logged in, redirect them to login+register page
if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = new User($_SESSION['userLoggedIn']);
    $_SESSION["name"] = $userLoggedIn->getName();
    $_SESSION["id"] = $userLoggedIn->getId();
    $_SESSION["email"] = $userLoggedIn->getEmail();;
    $_SESSION["profilePic"] = $userLoggedIn->getProfilePhotoPath();
    $_SESSION["role"] = $userLoggedIn->getRoleName();

    echo "<script> var userLoggedIn = '" . $_SESSION['userLoggedIn'] . "'; </script>";
}
else {
    header("Location: authenticate.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <title>covertAudio</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Go Covert for Underground Tracks">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script src="assets/js/init-alpine.js" defer></script>

    <!-- <style> @font-face { font-family: 'Raleway'; src: url('assets/fonts/Raleway.ttf'); } </style> -->

    <link rel="stylesheet" href="assets/css/font-awesome.min.css" defer>
    <link rel="stylesheet" href="assets/css/tailwind.output.css" />

    <link rel="icon" type="image/x-icon" href="assets/images/icons/favicon.ico">
</head>

<body x-data="data()" x-init="$watch('dark', value => document.documentElement.classList.toggle('dark', value))">

    <div id="mainContainer" class="mainContainer" :class="{ 'overflow-hidden': isSideMenuOpen }">

        <?php include("views/components/sideSearchBarContainer.php"); ?>
        <?php include("views/components/initialisePlayback.php"); ?>

        <div id="mainContent" class="mainContent">