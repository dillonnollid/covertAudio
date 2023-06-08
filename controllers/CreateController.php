<?php
if(session_status() == PHP_SESSION_NONE) { //session has not started
    session_start();
}
class CreateController{
    private $getID3;
    private $con;
    private $redirect;

    public function __construct(){
        require_once dirname(__DIR__) . '/vendor/autoload.php';
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $dbHost = $_ENV['DB_HOST'];
        $dbUsername = $_ENV['DB_USERNAME'];
        $dbPassword = $_ENV['DB_PASSWORD'];
        $dbDatabase = $_ENV['DB_DATABASE'];

        $this->con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);
        
        include_once("getID3/getid3/getid3.php");
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
        $uploadDir = 'assets/music/';
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
        $uploadDir = 'assets/images/artwork/';
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