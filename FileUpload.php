<?php
    require_once "controllers/CreateController.php";
    $createController = new CreateController();
    $redirect = 'index.php';

    if (isset($_FILES['upload'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $createController->addSong();
        }
    } elseif(isset($_FILES['imgupload'])){
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['add']=="album") {
            $createController->addAlbum();
        }
    } elseif(isset($_POST['add'])){
        $choice = $_POST['add'];
        if($choice=="artist"){
            $createController->addArtist();
        } elseif($choice=="genre"){
            $createController->addGenre();
        }

    }
    //After operation is complete (and success or error messages applied to session vars), redirect to homepage. 
    header("Location: $redirect");
?>