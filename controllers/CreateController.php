<?php
namespace controllers;

use getID3;
use models\Database;
use models\User;

if(session_status() == PHP_SESSION_NONE) { //session has not started
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

class CreateController{
    private $getID3;
    private $con;
    private $redirect;

    public function __construct(){
        //include_once(__DIR__ . "/../vendor/autoload.php");
        $this->con = Database::getInstance()->getConnection();

        include_once(__DIR__ . "/../getID3/getid3/getid3.php");
        $this->getID3 = new getID3;
        $this->redirect = 'views/pages/browse.php';
    }

    public function addSong() {
        //Collect values from input fields
        //$songSource = $_POST['songSource'];//Not needed yet
        $artistID = $_POST['artistID'];
        $songTitle = $_POST['songTitle'];
        $albumID = $_POST['albumID'];
        $genre = $_POST['genre'];

        $newTitle = trim($songTitle);
        $newTitle = str_replace(' ', '-', $newTitle);
        $newTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $newTitle);
        $uploadDir = __DIR__ . "/../assets/music/";
        $path = $uploadDir . $newTitle . ".mp3";
        $uploadedFile = $uploadDir . basename($path);

        if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadedFile)) {
            $ThisFileInfo = $this->getID3->analyze($path);
            $len = $ThisFileInfo['playtime_string'];

            $sql = "INSERT INTO songs " .
                "(title,artist,album,genre,duration,path,albumOrder,plays) " . "VALUES " .
                "('$songTitle',$artistID,$albumID,$genre,'$len','$path',1,1)";

            if (mysqli_query($this->con,$sql) == 1) {
                $_SESSION['success'] = "New song record created successfully: " . (string)$songTitle;
            } else {
                $_SESSION['error'] =  "Error: " . $sql . $this->con->error;
            }
        } else {
            $_SESSION['error'] =  "Error: There was a problem saving the uploaded file";
        }
    }

    public function addAlbum(){
        $albumTitle = $_POST['albumTitle'];
        $artist = $_POST['artistID'];
        $genre = $_POST['genre'];

        $newTitle=trim($albumTitle);
        $uploadDir = __DIR__ . "/../assets/images/profile-pics/";
        $path=$uploadDir . $newTitle . ".jpg";
        $uploadedFile = $uploadDir . basename($path);

        if(move_uploaded_file($_FILES['imgupload']['tmp_name'], $uploadedFile)) {

            $sql = "INSERT INTO albums ".
                "(title,artist,genre,artworkPath) "."VALUES ".
                "('$albumTitle','$artist','$genre','$path')";

            if (mysqli_query($this->con,$sql) == 1) {
                $_SESSION['success'] = "New album created successfully: " . (string)$albumTitle;
            } else {
                $_SESSION['error'] =  "Error: " . $sql . $this->con->error;
            }
        } else {
            $_SESSION['error'] =  "Error: There was a problem saving the uploaded file";
        }

    }

    public function addArtist(){
        $artist = $_POST['songArtist'];
        $genre = $_POST['genre'];
        $sql = "INSERT INTO artists ".
            "(name,genre) "."VALUES ".
            "('$artist','$genre')";

        if (mysqli_query($this->con,$sql) == 1) {
            $_SESSION['success'] = "New artist created successfully: " . $artist;
        } else {
            $_SESSION['error'] =  "Error: " . $sql . $this->con->error;
        }

    }

    public function addGenre(){
        $genre = $_POST['genre'];

        $sql = "INSERT INTO genres ".
            "(name) "."VALUES ".
            "('$genre')";

        if (mysqli_query($this->con,$sql) == 1) {
            $_SESSION['success'] = "New genre created successfully: " . $genre;
        } else {
            $_SESSION['error'] =  "Error: " . $sql . $this->con->error;
        }
    }

}
?>