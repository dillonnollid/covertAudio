<?php
	//TEST CODE TO SCAN DIR
	//$dir = "/xampp/htdocs/RareTracks/sourceFull/assets/music";
	// Sort in ascending order - this is default
	//$a = scandir($dir);
	//print_r($a);

    include("includes/config.php");
    include_once("getID3/getid3/getid3.php");
    $getID3 = new getID3;

    if (isset($_FILES['upload'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // collect value of input field
            $songSource = $_POST['songSource'];
            $artistID = $_POST['artistID'];
            $songTitle = $_POST['songTitle'];
            $albumID = $_POST['albumID'];
            $genre = $_POST['genre'];

            $newTitle=trim($songTitle);// . "AID=" . $artistID;
            $uploadDir = 'assets/music/';
            $path=$uploadDir . $newTitle . ".mp3";
            $uploadedFile = $uploadDir . basename($path);/*$_FILES['upload']['name'] */
            
            //echo "BASENAME IS " . $path;//basename($_FILES['upload']['name']);die();

            if(move_uploaded_file($_FILES['upload']['tmp_name'], $uploadedFile)) {
                echo '<br>Audio File was uploaded successfully.<br>';
                $ThisFileInfo = $getID3->analyze($path);
                $len= $ThisFileInfo['playtime_string'];
                //print_r($ThisFileInfo); die();
                  
                $sql = "INSERT INTO songs ".
                       "(title,artist,album,genre,duration,path,albumOrder,plays) "."VALUES ".
                       "('$songTitle',$artistID,$albumID,$genre,'$len','$path',1,1)";

                if (mysqli_query($con,$sql) == 1) {
                  echo "New song record created successfully<br>" . $songTitle . " " . $artistID . " " . $albumID;
                } else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo '<br>There was a problem saving the uploaded file<br>';
            }
            echo '<br/><a href="album.php?id=' . $albumID . '">Go To Album</a>';
    }
} elseif(isset($_FILES['imgupload'])){
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['add']=="album") {
        $albumTitle = $_POST['albumTitle'];
        $artist = $_POST['artistID'];
        $genre = $_POST['genre'];

        $newTitle=trim($albumTitle);// . "AID=" . $artistID;
        $uploadDir = 'assets/images/artwork/';
        $path=$uploadDir . $newTitle . ".jpg";
        $uploadedFile = $uploadDir . basename($path);

        
        if(move_uploaded_file($_FILES['imgupload']['tmp_name'], $uploadedFile)) {
            echo '<br>Album Artwork was uploaded successfully.<br>';
            //$ThisFileInfo = $getID3->analyze($path);
            //$len= $ThisFileInfo['playtime_string'];
            //print_r($ThisFileInfo); die();
              
            $sql = "INSERT INTO albums ".
               "(title,artist,genre,artworkPath) "."VALUES ".
               "('$albumTitle','$artist','$genre','$path')";

            if (mysqli_query($con,$sql) == 1) {
              echo "New album created successfully: " . $albumTitle . "<br>";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo '<br>There was a problem saving the uploaded file<br>';
        }
        echo '<br/><a href="browse.php">Go Back to Website</a>';

    }
}


if(isset($_POST['add'])){
    $choice = $_POST['add'];
    //Conditions determine what we are gonna add to the DB. Prob shouldn't be in the FileUpload code lol. Move later
    if($choice=="artist"){
        $artist = $_POST['songArtist'];
        $genre = $_POST['genre'];
        $sql = "INSERT INTO artists ".
               "(artist,genre) "."VALUES ".
               "('$artist','$genre')";

        if (mysqli_query($con,$sql) == 1) {
          echo "New artist created successfully: " . $artist . " <br>";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif($choice=="album"){
        
    } elseif($choice=="genre"){
        $genre = $_POST['genre'];

        $sql = "INSERT INTO genres ".
               "(name) "."VALUES ".
               "('$genre')";

        if (mysqli_query($con,$sql) == 1) {
          echo "New Genre created successfully:" . $genre . "<br>";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

}
?>