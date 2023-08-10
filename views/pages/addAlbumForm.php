<?php
include_once __DIR__ . '/../../models/Database.php';
$con = models\Database::getInstance()->getConnection();
?>

<div class="contributeContainer">
    <div class="centerStuff">
        <h1 class="generalCenteredText">Add Album! </h1>
        <h2 class="generalCenteredText">(Existing Albums listed below)</h2><br>

        <form action="/controllers/FormController.php" method="post" enctype="multipart/form-data">
            <input type="text" name="albumTitle" placeholder="Album Title" class="generalInput" required/>
            <select name="artistID" id="ART" class="generalInput" required>
                <option value="" disabled selected>Select the artist!</option>
                <?php
                $artistQuery = mysqli_query($con, "SELECT * FROM artists");
                $i=1;
                while($row = mysqli_fetch_array($artistQuery)) {
                    echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
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

            <input type="hidden" name="action" value="addAlbum">
            <input type="file" name="imgupload" id="upload" placeholder="Choose Album artwork To Upload" class="generalInput" required><br/>
            <input type="submit" name="submit" value="Upload" class="generalInput">
        </form>
    </div>

    <?php
    // Display existing albums (similarly for other entities)
    echo "<br><hr><br>";
    $albumQuery = mysqli_query($con, "SELECT * FROM albums");
    $i=1;
    echo "<ul class='generalCenteredText'><li>Existing Albums (Please don't duplicate)</li><br>";
    while($row = mysqli_fetch_array($albumQuery)) {
        $name=$row['title'];
        echo "<li>$name</li>";
        $i+=1;
    }
    echo "</ul>";
    ?>
</div>
