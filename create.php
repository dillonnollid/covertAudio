<?php 
include("includes/includedFiles.php"); 
?>

<h1 class="pageHeadingBig"></h1>

<div class="container px-6 mx-auto grid">

	<?php if(isset($_GET["id"]) && trim($_GET["id"]) == 'song'){ ?>
		<div class="items-center justify-center p-6">
			<h1 class="text-gray-600 dark:text-gray-400 text-center"><a href="https://ytmp3.cc/" target="blank">Add Song! <br>Click here go to youtube downloader. <br>Download MP3 in top quality and upload the file below!</a><br></h1>
			
			<hr>
	        <form action="FileUpload.php" method="post" enctype="multipart/form-data">
	        	<input type="text" name="songSource" placeholder="Youtube URL (Not Available yet, use youtubeToMP3 link above)" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" disabled/>
	        	<input type="text" name="songTitle" placeholder="Song Title" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>


				<select name="artistID" id="ART" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
					<option value="" class="" disabled selected>Select the artist!</option>
				<?php
					$artistQuery = mysqli_query($con, "SELECT * FROM artists");
					$i=1;
					while($row = mysqli_fetch_array($artistQuery)) {
						echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
					}

				?>
				</select>

				<select name="albumID" id="ART" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
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
				
				<select name="genre" id="ART" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
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
	            <input type="file" name="upload" id="upload" placeholder="Choose File To Upload" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"><br/>
	            <hr>
	            <input type="submit" name="submit" value="Upload" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
	        </form>
		</div>

		<?php echo "<br><hr><br>";
		$songQuery = mysqli_query($con, "SELECT * FROM songs");
			$i=1;
			echo "<ul class='text-gray-600 dark:text-gray-400 text-center' style='padding:6%;text-size:20px;'>Existing Songs (Please don't duplicate)";
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
		<div class="items-center justify-center p-6">
			<h1 class="text-gray-600 dark:text-gray-400 text-center">Add Artist! </h1>
			<h2 class="text-gray-600 dark:text-gray-400 text-center">(Existing artists listed below)</h2>
				
	        <form action="FileUpload.php" method="post" enctype="multipart/form-data">
				<input type="text" name="songArtist" placeholder="Artist Name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
							
				<input type="text" name="genre" placeholder="Genre" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
				<input type="hidden" name="add" value="artist" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
	            <hr>
	            <input type="submit" name="submit" value="Upload" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">

	        </form>
		</div>
		<?php
		echo "<br><hr><br>";
		$artistQuery = mysqli_query($con, "SELECT * FROM artists");
			$i=1;
			echo "<ul class='form-add-song' style='padding:6%;text-size:20px;'>Existing Artists (Please don't duplicate)";
			while($row = mysqli_fetch_array($artistQuery)) {
				$name=$row['name'];
				echo "<li>$name</li>";
				$i+=1;
			}
			echo "</ul>"; ?>
	<?php } elseif(isset($_GET["id"]) && trim($_GET["id"]) == 'album'){ ?>
		<div class="items-center justify-center p-6">
			<h1 class="text-gray-600 dark:text-gray-400 text-center">Add Album! </h1>
			<h2 class="text-gray-600 dark:text-gray-400 text-center">(Existing Albums listed below)</h2>
				
	        <form action="FileUpload.php" method="post" enctype="multipart/form-data">
				<input type="text" name="albumTitle" placeholder="Album Title" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
				<select name="artistID" id="ART" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
					<option value="" disabled selected>Select the artist!</option>
				<?php
					$artistQuery = mysqli_query($con, "SELECT * FROM artists");
					$i=1;
					while($row = mysqli_fetch_array($artistQuery)) {
						echo '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
					}
				?>
				</select>			
				
				<select name="genre" id="ART" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
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
				<input type="file" name="imgupload" id="upload" placeholder="Choose Album artwork To Upload" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"><br/>
	            <hr>
	            <input type="submit" name="submit" value="Upload" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
	        </form>
		</div>

		<?php echo "<br><hr><br>";
		$albumQuery = mysqli_query($con, "SELECT * FROM albums");
			$i=1;
			echo "<ul class='text-gray-600 dark:text-gray-400 text-center' style='padding:6%;text-size:20px;'>Existing Albums (Please don't duplicate)";
			while($row = mysqli_fetch_array($albumQuery)) {
				$name=$row['title'];
				echo "<li>$name</li>";
				$i+=1;
			}
			echo "</ul>";
		} elseif(isset($_GET["id"]) && trim($_GET["id"]) == 'genre'){ ?>
			<div class="items-center justify-center p-6">
				<h1 class="text-gray-600 dark:text-gray-400 text-center">Add Genre!</h1>
				<h2 class="text-gray-600 dark:text-gray-400 text-center">(Existing Genres listed below)</h2>
					
		        <form action="FileUpload.php" method="post" enctype="multipart/form-data">
					<input type="text" name="genre" placeholder="Genre Name (Please don't duplicate)" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
		            <hr>
		            <input type="hidden" name="add" value="genre" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
		            <input type="submit" name="submit" value="Upload" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
		        </form>
			</div>

		<?php echo "<br><hr><br>";
		$genreQuery = mysqli_query($con, "SELECT * FROM genres");
			echo "<ul class='form-add-song' style='padding:6%;text-size:20px;'>Existing Genres (Please don't duplicate)";
			while($row = mysqli_fetch_array($genreQuery)) {
				$name=$row['name'];
				echo "<li>$name</li>";
			}
			echo "</ul>";
		}?>
</div>