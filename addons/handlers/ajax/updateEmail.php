<?php

include("../../config.php");

if(!isset($_POST['username'])){
    echo "ERROR: no username set";
}

if(isset($_POST['email']) && $_POST['email'] !== ""){
    $email = $_POST['email'];
    $username = $_POST['username'];
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Come on, That's an invalid Email";
        exit();
    }
    
    $emailCheck = mysqli_query($con, "SELECT email FROM users WHERE email='$email' AND username!='$username'");
    if(mysqli_num_rows($emailCheck) > 0){
        echo "Email is already in use.";
        exit();
    }
    
    $updateQuery = mysqli_query($con, "UPDATE users SET email='$email' WHERE username='$username'");
    
    echo "Updated Successfully";
}
else{
    echo "You must provide an Email";
}

?>