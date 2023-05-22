<?php 
include("includes/includedFiles.php"); 
?>

<div class="contributeContainer">

	<?php if(isset($_GET["id"]) && trim($_GET["id"]) == 'song'){ ?>
		<div class="centerStuff">

			<h1 class="generalCenteredText"><a href="https://mp3-convert.org/youtube-to-mp3/" target="blank">Add Song!<br>Click here go to youtube downloader. <br>Download MP3 in top quality and upload the file below!</a><br></h1>
			<br>

	        <form action="FileUpload.php" method="post" enctype="multipart/form-data">
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
				<input type="hidden" name="add" value="song">
	            <input type="file" name="upload" id="upload" placeholder="Choose File To Upload" class="generalInput" required><br/>
	            <br>
	            <input type="submit" name="submit" value="Upload" class="generalInput">
	        </form>
		</div>

		<?php echo "<br><hr>";
		$songQuery = mysqli_query($con, "SELECT * FROM songs");
			$i=1;
			echo "<ul class='generalCenteredText'><li>Existing Songs (Please don't duplicate)</li><br>";
			while($row = mysqli_fetch_array($songQuery)) {
				$name=$row['title'];
				echo "<li>$name</li>";
				$i+=1;
			}
			echo "</ul>"; 
			//YOUTUBE DL
            // YOUTUBE VIDEO ID
 			//$id = '3e69G8LPqEg';

			 // FETCHING DATA FROM SERVER
			 //$jsonData = file_get_contents("https://api.vevioz.com/?v=3e69G8LPqEg&type=mp3&bitrate=320");
			 //$links = json_decode($jsonData,TRUE);

			 //print_r($links);die();
			?>
	<?php } elseif(isset($_GET["id"]) && trim($_GET["id"]) == 'artist'){ ?>
		<div class="centerStuff">
			<h1 class="generalCenteredText">Add Artist! </h1>
			<h2 class="generalCenteredText">(Existing artists listed below)</h2><br>
				
	        <form action="FileUpload.php" method="post" enctype="multipart/form-data">
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
		echo "<br><hr><br>";
		$artistQuery = mysqli_query($con, "SELECT * FROM artists");
			$i=1;
			echo "<ul class='generalCenteredText'><li>Existing Artists (Please don't duplicate)</li><br>";
			while($row = mysqli_fetch_array($artistQuery)) {
				$name=$row['name'];
				echo "<li>$name</li>";
				$i+=1;
			}
			echo "</ul>"; ?>
	<?php } elseif(isset($_GET["id"]) && trim($_GET["id"]) == 'album'){ ?>
		<div class="centerStuff">
			<h1 class="generalCenteredText">Add Album! </h1>
			<h2 class="generalCenteredText">(Existing Albums listed below)</h2><br>
				
	        <form action="FileUpload.php" method="post" enctype="multipart/form-data">
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

				<input type="hidden" name="add" value="album" />
				<input type="file" name="imgupload" id="upload" placeholder="Choose Album artwork To Upload" class="generalInput" required><br/>
	            <input type="submit" name="submit" value="Upload" class="generalInput">
	        </form>
		</div>

		<?php echo "<br><hr><br>";
		$albumQuery = mysqli_query($con, "SELECT * FROM albums");
			$i=1;
			echo "<ul class='generalCenteredText'><li>Existing Albums (Please don't duplicate)</li><br>";
			while($row = mysqli_fetch_array($albumQuery)) {
				$name=$row['title'];
				echo "<li>$name</li>";
				$i+=1;
			}
			echo "</ul>";
		} elseif(isset($_GET["id"]) && trim($_GET["id"]) == 'genre'){ ?>
			<div class="centerStuff">
				<h1 class="generalCenteredText">Add Genre!</h1>
				<h2 class="generalCenteredText">(Existing Genres listed below)</h2><br>
					
		        <form action="FileUpload.php" method="post" enctype="multipart/form-data">
					<input type="text" name="genre" placeholder="Genre Name (Please don't duplicate)" class="generalInput" required/>
		            <br>
		            <input type="hidden" name="add" value="genre"/>
		            <input type="submit" name="submit" value="Upload" class="generalInput">
		        </form>
			</div>

		<?php echo "<br><hr><br>";
		$genreQuery = mysqli_query($con, "SELECT * FROM genres");
			echo "<ul class='generalCenteredText'><li>Existing Genres (Please don't duplicate)</li><br>";
			while($row = mysqli_fetch_array($genreQuery)) {
				$name=$row['name'];
				echo "<li>$name</li>";
			}
			echo "</ul>";
		}?>
</div>