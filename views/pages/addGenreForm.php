<?php
include_once __DIR__ . '/../../models/Database.php';
$con = models\Database::getInstance()->getConnection();
?>

<div class="contributeContainer">
    <div class="centerStuff">
        <h1 class="generalCenteredText">Add Genre!</h1>
        <h2 class="generalCenteredText">(Existing Genres listed below)</h2><br>

        <form action="controllers/FormController.php" method="post" enctype="multipart/form-data">
            <input type="text" name="genre" placeholder="Genre Name (Please don't duplicate)" class="generalInput" required/>
            <br>
            <input type="hidden" name="action" value="addGenre">
            <input type="submit" name="submit" value="Upload" class="generalInput">
        </form>
    </div>

    <?php
    // Display existing genres (similarly for other entities)
    echo "<br><hr><br>";
    $genreQuery = mysqli_query($con, "SELECT * FROM genres");
    echo "<ul class='generalCenteredText'><li>Existing Genres (Please don't duplicate)</li><br>";
    while($row = mysqli_fetch_array($genreQuery)) {
        $name=$row['name'];
        echo "<li>$name</li>";
    }
    echo "</ul>";
    ?>
</div>
