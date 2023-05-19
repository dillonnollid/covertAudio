<?php  
include("includes/includedFiles.php");
?>

<div class="pageContainer">

	<div class="centerSection">
		<div class="userInfo">
			<h1 class="generalCenteredText text-lg"><?php echo $_SESSION['name']; ?></h1>
			<h1 class="generalCenteredText text-lg"><?php echo $_SESSION['email']; ?></h1>
			<h1 class="generalCenteredText text-lg"><?php echo $_SESSION['userLoggedIn']; ?></h1>
			<h1 class="generalCenteredText text-lg"><?php echo $_SESSION['role']; ?></h1>
		</div>
	</div>
 
	<div class="buttonItems">
		<!--<button class="button mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">USER DETAILS</button>-->
        <br>
		<a href="logout.php" class="submitButton">LOGOUT</a>
	</div>

</div>