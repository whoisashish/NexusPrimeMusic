<?php
include("../../config.php");
if(null !== $_POST['playlistId'] && null !== $_POST['songId']){
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];
    
    $orderIdQuery = mysqli_query($con, "SELECT IFNULL(MAX(playlistOrder) + 1, 1) as playlistOrder FROM playlistSongs WHERE playlistId='$playlistId'");
    $row = mysqli_fetch_array($orderIdQuery);
    $order = $row['playlistOrder'];
    
    $songCheck = mysqli_query($con, "SELECT * FROM playlistSongs WHERE playlistId='$playlistId' and songId='$songId'");
    if(mysqli_num_rows($songCheck) != 1){
    mysqli_query($con, "INSERT INTO playlistSongs VALUES('', '$songId', '$playlistId', '$order')");
}
}
else{
    echo "PlaylistId or songId was not passed";
}

?>