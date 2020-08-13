<?php

include("addons/includedFiles.php");

?>


<div class="userDetails">
    <div class="container borderBottom">
        <h2 class="centerHeading stylish">EMAIL</h2>
        <input type="text" name="email" class="email" placeholder="Email address..." value="<?php echo lcfirst($userLoggedIn->getEmail()); ?>" spellcheck="false">
        <span class="message"></span>
        <button class="buttonLogOut" onclick="updateEmail('email')">SAVE</button>
    </div>
    <div class="container">
        <h2 class="centerHeading stylish">PASSWORD</h2>    
        <input type="password" name="oldPassword" class="oldPassword" placeholder="Current Password" spellcheck="false">
        <input type="password" name="newPassword1" class="newPassword1" placeholder="New Password" spellcheck="false">
        <input type="password" name="newPassword2" class="newPassword2" placeholder="Confirm Password" spellcheck="false">
        <span class="message"></span>
        <button class="buttonLogOut" onclick="updatePassword('oldPassword','newPassword1','newPassword2')">SAVE</button>    
    </div>
</div>