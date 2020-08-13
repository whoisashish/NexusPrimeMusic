<?php

include("addons/includedFiles.php");
    if(isset($_GET['id'])){
        $artistId = $_GET['id'];
    }
    else{
        header('Location: index.php');
    }

$artist = new Artist($con, $artistId);

?>




<div class="entityInfo borderBottom">
    <div class="centerSection">
        <div class="artistInfo">
            <h1 class="artistName stylish"><?php echo $artist->getName() ?></h1>
            <div class="headerButtons">
                <button class="buttonMy" onclick="playFirstSong()">PLAY</button>
            </div>
        </div>
    </div>
</div>


<div class="trackListContainer borderBottom">
    <h2 class="centerHeading">Popular</h2>
    <ul class="trackList">

        <?php
            $songIdArray = $artist->getSongIds();
        $i = 1;
        
        foreach($songIdArray as $songId){
            
            if($i > 5){
                break;
            }
            
            $albumSong = new Song($con, $songId);
            $albumArtist = $albumSong->getArtist();
            
            echo "<li class='trackListRow'>
                    <div class='trackCount'>
                        <img class='play' src='assets/images/icons/pPlay.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                        <span class='trackNumber'>$i</span>
                    </div>
                    <div class='trackInfo' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                        <span class='trackName'>" . $albumSong->getTitle() . "</span>
                        <span class='artistName'>" . $albumArtist->getName() . "</span>
                    </div>
                    <div class='trackOptions'>
                    <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                        <img src='assets/images/icons/more.png' class='optionsButton' onclick='showOptionsMenu(this)'>
                    </div>
                    <div class='trackDuration'>
                        <span class='duration'>" . $albumSong->getDuration() . "</span>
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
<h2 class="centerHeading">Albums</h2>
<div class="gridViewContainer">

    <?php
        $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");
    
    while($row = mysqli_fetch_array($albumQuery)){
        
        echo "   <div class='gridWrapper'>
                <span onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
                 <div class='gridViewItem'>
                    
                  <img src='"  . $row['artworkPath'] . "'>  
                
                </div>
                <div class='gridViewInfo'>
                  " . $row['title'] ."
                  </div>
                  </span>
                  </div>";
    }
    ?>
</div>


<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>