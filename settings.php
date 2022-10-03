<?php  
include("includes/includedFiles.php");
?>

<div class="entityInfo">

	<div class="centerSection">
		<div class="userInfo">
			<h1 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"><?php echo $userLoggedIn->getFirstAndLastName(); ?></h1>
		</div>
	</div>

	<div class="buttonItems">
		<button class="button mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">USER DETAILS</button>
        <br>
		<a href="logout.php" class="button mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">LOGOUT</a>
	</div>


</div>