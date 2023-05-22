<?php 
$successMsg = "";
$errorMsg = "";

if(isset($_SESSION['success'])) {
    $successMsg = htmlspecialchars($_SESSION['success']);
    unset($_SESSION['success']);
}

if(isset($_SESSION['error'])) {
    $errorMsg = htmlspecialchars($_SESSION['error']);
    unset($_SESSION['error']);
}
?>

<div class="centeredContainer">
    <?php if ($successMsg !== ""){ ?>
        <div class="successBox" role="alert">
            <p class="font-bold">Success</p>
            <p><?php echo $successMsg;?></p>
        </div>
    <?php } ?>

    <?php if($errorMsg !== ""){ ?>
        <div class="" role="alert">
            <p class="font-bold">Error</p>
            <p><?php echo $errorMsg;?></p>
        </div>
    <?php } ?>
</div>

