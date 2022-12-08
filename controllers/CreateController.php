<?php
class CreateController{
    private $getID3;
    private $con;

    public function __construct(){
        $this->con = mysqli_connect("localhost", "root", "", "slotify");
        include_once("getID3/getid3/getid3.php");
        $this->getID3 = new getID3;
    }

    public function addSong() {
        // collect value of input fields
        //$songSource = $_POST['songSource'];//Not needed yet
        $artistID = $_POST['artistID'];
        $songTitle = $_POST['songTitle'];
        $albumID = $_POST['albumID'];
        $genre = $_POST['genre'];

        $newTitle = trim($songTitle);// . "-AID-" . $artistID;
        $newTitle = str_replace(' ', '-', $newTitle);
        $newTitle = preg_replace('/[^A-Za-z0-9\-]/', '', $newTitle);
        $uploadDir = 'assets/music/';
        $path = $uploadDir . $newTitle . ".mp3";
        $uploadedFile = $uploadDir . basename($path);

        if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadedFile)) {
            echo '<br>Audio File was uploaded successfully.<br>';
            $ThisFileInfo = $this->getID3->analyze($path);
            $len = $ThisFileInfo['playtime_string'];

            $sql = "INSERT INTO songs " .
                "(title,artist,album,genre,duration,path,albumOrder,plays) " . "VALUES " .
                "('$songTitle',$artistID,$albumID,$genre,'$len','$path',1,1)";

            if (mysqli_query($this->con, $sql) == 1) {
                echo "New song record created successfully<br>" . $songTitle . " " . $artistID . " " . $albumID;
            } else {
                echo "Error: " . $sql . "<br>" . $this->con->error;
            }
        } else {
            echo '<br>There was a problem saving the uploaded file<br>';
        }
        echo '<br/><a href="albumView.php?id=' . $albumID . '">Go To Album</a>';
    }

    public function addAlbum(){
        $albumTitle = $_POST['albumTitle'];
        $artist = $_POST['artistID'];
        $genre = $_POST['genre'];

        $newTitle=trim($albumTitle);// . "AID=" . $artistID;
        $uploadDir = 'assets/images/artwork/';
        $path=$uploadDir . $newTitle . ".jpg";
        $uploadedFile = $uploadDir . basename($path);

        if(move_uploaded_file($_FILES['imgupload']['tmp_name'], $uploadedFile)) {
            echo '<br>Album Artwork was uploaded successfully.<br>';

            $sql = "INSERT INTO albums ".
                "(title,artist,genre,artworkPath) "."VALUES ".
                "('$albumTitle','$artist','$genre','$path')";

            if (mysqli_query($this->con,$sql) == 1) {
                echo "New album created successfully: " . $albumTitle . "<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $this->con->error;
            }
        } else {
            echo '<br>There was a problem saving the uploaded file<br>';
        }
        echo '<br/><a href="browse.php">Go Back to Website</a>';

    }

    public function addArtist(){
        $artist = $_POST['songArtist'];
        $genre = $_POST['genre'];
        $sql = "INSERT INTO artists ".
            "(name,genre) "."VALUES ".
            "('$artist','$genre')";

        if (mysqli_query($this->con,$sql) == 1) {
            echo "New artist created successfully: " . $artist . " <br>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->con->error;
        }

    }

    public function addGenre(){
        $genre = $_POST['genre'];

        $sql = "INSERT INTO genres ".
            "(name) "."VALUES ".
            "('$genre')";

        if (mysqli_query($this->con,$sql) == 1) {
            echo "New Genre created successfully:" . $genre . "<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $this->con->error;
        }
    }

}
?>