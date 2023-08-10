<?php
include_once __DIR__ . '/../../models/Database.php';
$con = models\Database::getInstance()->getConnection();
?>

<div class="contributeContainer">
    <div class="centerStuff">
        <h1 class="generalCenteredText"><a href="https://mp3-convert.org/youtube-to-mp3/" target="blank">Add Song!<br>Click here go to youtube downloader. <br>Download MP3 in top quality and upload the file below!</a><br></h1>
        <br>

        <form action="/controllers/FormController.php" method="post" enctype="multipart/form-data">
            <!--<input type="text" name="songSource" placeholder="Youtube URL (Not Available yet, use youtubeToMP3 link above)" class="generalInput" disabled/>-->
            <input type="text" name="songTitle" placeholder="Song Title" class="generalInput" required/>

            <select name="artistID" id="ART" class="generalInput" required>
                <option value="" class="" disabled selected>Select the artist!</option>
                <?php
                $artistQuery = mysqli_query($con, "SELECT * FROM artists");
                $i=1;
                while($row = mysqli_fetch_array($artistQuery)) {
                    echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                }
                ?>
            </select>

            <select name="albumID" id="ART" class="generalInput" required>
                <option value="" disabled selected>Select the album!</option>
                <?php
                $albumQuery = mysqli_query($con, "SELECT * FROM albums");
                $i=1;
                while($row = mysqli_fetch_array($albumQuery)) {
                    echo '<option value=' . $row['id'] . '>' . $row['title'] . '</option>';
                    $i+=1;
                }
                ?>
            </select>

            <select name="genre" id="ART" class="generalInput" required>
                <option value="" disabled selected>Select the genre!</option>
                <?php
                $genreQuery = mysqli_query($con, "SELECT * FROM genres");
                $i=1;
                while($row = mysqli_fetch_array($genreQuery)) {
                    echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                    $i+=1;
                }
                ?>
            </select>
            <input type="hidden" name="action" value="addSong">
            <input type="file" name="upload" id="upload" placeholder="Choose File To Upload" class="generalInput" required><br/>
            <br>
            <input type="submit" name="submit" value="Upload" class="generalInput">
        </form>
    </div>

    <?php
        // Display existing songs (similarly for other entities)
        echo "<br><hr>";
        $songQuery = mysqli_query($con, "SELECT * FROM songs");
        $i=1;
        echo "<ul class='generalCenteredText'><li>Existing Songs (Please don't duplicate)</li><br>";
            while($row = mysqli_fetch_array($songQuery)) {
                $name=$row['title'];
                echo "<li>$name</li>";
                $i+=1;
            }
        echo "</ul>";

    //YOUTUBE DL FOR ANOTHER TIME
    // YOUTUBE VIDEO ID
    //$id = '3e69G8LPqEg';

    // FETCHING DATA FROM SERVER
    //$jsonData = file_get_contents("https://api.vevioz.com/?v=3e69G8LPqEg&type=mp3&bitrate=320");
    //$links = json_decode($jsonData,TRUE);

    //print_r($links);die();
    ?>

</div>