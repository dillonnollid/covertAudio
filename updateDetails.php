<?php
include("includes/includedFiles.php");
?>

<div class="pageContainer md:flex-col md:p-12 space-y-8">
	<form class="container mx-auto">
		<h2 class="themeText">Update Email</h2>
		<input type="text" class="generalInput" name="email" placeholder="Enter email address here" value="<?php echo $_SESSION["email"]; ?>">
		<span class="themeText message"></span>
		<button class="submitButton" onclick="updateEmail('email')">SAVE EMAIL</button>
	</form>

	<hr>

	<form class="container mx-auto">
		<h2 class="themeText">Update Password</h2>
		<input type="password" class="generalInput oldPassword" name="oldPassword" placeholder="Current password">
		<input type="password" class="generalInput newPassword1" name="newPassword1" placeholder="New password">
		<input type="password" class="generalInput newPassword2" name="newPassword2" placeholder="Confirm password">
		<span class="themeText message"></span>
		<button class="submitButton" onclick="updatePassword('oldPassword', 'newPassword1', 'newPassword2')">SAVE PASSWORD</button>
	</form>

	<form class="container mx-auto">
		<h2 class="themeText">Update Profile Photo</h2>
		<input type="file" name="imgupload" id="upload" placeholder="Choose Album artwork To Upload" class="generalInput" required>
		<span class="themeText message"></span>
		<button class="submitButton" onclick="updateProfilePhoto('imgupload')">SAVE PROFILE PHOTO</button>
	</form>

</div>