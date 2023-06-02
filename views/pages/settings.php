<?php  
require(__DIR__ . '/../../includes/includedFiles.php');
?>

<div class="pageContainer md:flex-col md:p-12 space-y-8">

	<div class="">
		<img src="<?php echo $_SESSION['profilePic'];?>" class="albumArtwork">

		<div class="generalCenteredText">
			Hello, <?php echo $_SESSION['name']; ?>
		</div>
	</div>

	<!--<div class="centerSection">
		<div class="userInfo">
			<h1 class="generalCenteredText text-lg">Account Overview:</h1>
			<h2 class="generalCenteredText text-lg"><?php echo $_SESSION['name']; ?></h2>
			<h2 class="generalCenteredText text-lg"><?php echo $_SESSION['email']; ?></h2>
			<h2 class="generalCenteredText text-lg"><?php echo $_SESSION['userLoggedIn']; ?></h2>
			<h2 class="generalCenteredText text-lg"><?php echo $_SESSION['role']; ?></h2>
		</div>
	</div>-->

	<form class="centeredContainer" action="formHandler.php" method="post">
		<input type="hidden" name="action" value="updateEmail">
		<label for="email" class="labelStyle generalCenteredText">Update Email</label>
		<input type="text" class="generalInput" name="email" placeholder="Enter email address here" value="<?php echo $_SESSION["email"]; ?>" required>
		<input class="submitButton" type="submit" value="SAVE EMAIL">
	</form>

	<form class="centeredContainer" action="formHandler.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="updatePassword">
		<label for="oldPassword" class="labelStyle generalCenteredText">Update Password</label>
		<input type="password" class="generalInput oldPassword" name="oldPassword" placeholder="Current password" required>
		<input type="password" class="generalInput newPassword1" name="newPassword1" placeholder="New password" required>
		<input type="password" class="generalInput newPassword2" name="newPassword2" placeholder="Confirm password" required>
		<input class="submitButton" type="submit" value="SAVE PASSWORD">
	</form>

	<form class="centeredContainer" action="formHandler.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="updateProfilePhoto">
		<label for="imgupload" class="labelStyle generalCenteredText">Update Profile Photo</label>
		<input type="file" name="imgupload" placeholder="Choose Album artwork To Upload" class="generalInput" required>
		<input class="submitButton" type="submit" value="SAVE PROFILE PHOTO">
	</form>

</div>