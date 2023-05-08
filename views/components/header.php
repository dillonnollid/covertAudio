<?php
include("includes/config.php");
include("models/User.php");
include("models/Artist.php");
include("models/Album.php");
include("models/Song.php");

//If user's not logged in, redirect them to login+register page
if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
    echo "<div></div>";//$userLoggedIn->getName();
    $_SESSION["name"] = $userLoggedIn->getName();
    $_SESSION["profilePic"] = $userLoggedIn->getProfilePhotoPath();
    $_SESSION["role"] = $userLoggedIn->getRoleName();
}
else {
    header("Location: newRegister.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" :class="{ 'theme-dark': dark }" >
<head>
    <title>covertAudio</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/player.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="./assets/js/init-alpine.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/tailwind.output.css" />
</head>

<body x-data="data()" x-init="$watch('dark', value => document.documentElement.classList.toggle('dark', value))">

    <div id="mainContainer" class="flex bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">

        <?php include("views/components/sideSearchBarContainer.php"); ?>

        <div id="mainContent" class="container min-h-screen overflow-y-auto justify-center items-center">