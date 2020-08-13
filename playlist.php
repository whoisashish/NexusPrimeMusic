<?php include("addons/includedFiles.php");
    if(isset($_GET['id'])){
        $playlistId = $_GET['id'];
    }
    else{
        header('Location: index.php');
    }

    $playlist = new Playlist($con, $playlistId);
    $owner = new User($con, $playlist->getOwner());

?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="assets/images/icons/playlist.png" alt="">
    </div>
    <div class="rightSection">
        <h2><?php echo $playlist->getName(); ?></h2>
        <p>By <?php echo $playlist->getOwner(); ?></p>
        <p><?php echo $playlist->getNumberOfSongs(); ?> Songs</p>
        <button class="buttonMy" onclick="deletePlaylist('<?php echo $playlistId; ?>')">DELETE PLAYLIST</button>
    </div>
</div>

<div class="trackListContainer">
    <ul class="trackList">

        <?php
            $songIdArray = $playlist->getSongIds();
        $i = 1;
        
        foreach($songIdArray as $songId){
            $playlistSong = new Song($con, $songId);
            $songArtist = $playlistSong->getArtist();
            
            echo "<li class='trackListRow'>
                    <div class='trackCount'>
                        <img class='play' src='assets/images/icons/pPlay.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
                        <span class='trackNumber'>$i</span>
                    </div>
                    <div class='trackInfo' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
                        <span class='trackName'>" . $playlistSong->getTitle() . "</span>
                        <span class='artistName'>" . $songArtist->getName() . "</span>
                    </div>
                    <div class='trackOptions'>
                    <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
                        <img src='assets/images/icons/more.png' class='optionsButton' onclick='showOptionsMenu(this)'>
                    </div>
                    <div class='trackDuration'>
                        <span class='duration'>" . $playlistSong->getDuration() . "</span>
                    </div>
                </li>";
            
            $i = $i + 1;
        }
        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>

    </ul>
</div>


<nav class="optionsMenu">
    <input type="hidden" class="songId">
<!--    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>-->
    <div class="item" onclick="removeFromPlaylist(this, <?php echo $playlistId; ?>)">Remove from Playlist</div>
</nav>