<?php include('addons/includedFiles.php');
?>


<div class="playlistsContainer">
    <div class="gridViewContainer">
        <h2 class="centerHeading stylish">PLAYLISTS</h2>
        <div class="buttonItems">
            <button class="buttonMy" onclick="createPlaylist()">NEW PLAYLIST</button>
        </div>
        <div class="playlistWrapper">
            <?php
        
        $username = $userLoggedIn->getUsername();
            $playlistQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");
            if(mysqli_num_rows($playlistQuery) == 0){
                    echo "<span class='noResult'>You don't have any Playlists yet...</span>";
                }

            while($row = mysqli_fetch_array($playlistQuery)){
                
                $playlist = new Playlist($con, $row);

                echo "   <div class='gridWrapper playlistGridWrapper' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
                
                        <div class='playlistImage'>
                            <img src='assets/images/icons/playlist.png'>
                        </div>
                
                        <div class='gridViewInfo'>
                          " . $playlist->getName() ."
                          </div>
                          </div>";
            }
    ?>
        </div>
    </div>
</div>
