<?php

include("addons/includedFiles.php");

?>


<div class="entityInfo profile">
    
    <div class="centerSection">
        <div class="userInfo">
            <h1 class="centerHeading stylish"><?php echo $userLoggedIn->getFirstAndLastName(); ?></h1>
        </div>
    </div>
    <div class="buttonItems">
        <button class="buttonMy" onclick="openPage('updateDetails.php')">EDIT INFO</button>
        <button class="buttonLogOut" onclick="logout()">LOG OUT</button>
    </div>
</div>