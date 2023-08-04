<?php
include_once __DIR__ . '/../../models/Database.php';
$con = models\Database::getInstance()->getConnection();
?>

<div class="contributeContainer">
    <div class="centerStuff">
        <h1 class="generalCenteredText">Add Artist! </h1>
        <h2 class="generalCenteredText">(Existing artists listed below)</h2><br>

        <form action="includes/handlers/form-handler.php" method="post" enctype="multipart/form-data">
            <input type="text" name="songArtist" placeholder="Artist Name" class="generalInput" required/>

            <select name="genre" id="genre" class="generalInput" required>
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
            <br>
            <input type="hidden" name="add" value="artist"/>
            <input type="submit" name="submit" value="Upload" class="generalInput">
        </form>
    </div>

    <?php
    // Display existing artists (similarly for other entities)
    echo "<br><hr><br>";
    $artistQuery = mysqli_query($con, "SELECT * FROM artists");
    $i=1;
    echo "<ul class='generalCenteredText'><li>Existing Artists (Please don't duplicate)</li><br>";
    while($row = mysqli_fetch_array($artistQuery)) {
        $name=$row['name'];
        echo "<li>$name</li>";
        $i+=1;
    }
    echo "</ul>";
    ?>
</div>

