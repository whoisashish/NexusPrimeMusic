<?php include("addons/includedFiles.php"); ?>

<h1 class="pageHeadingBig">You might also like</h1>

<div class="gridViewContainer">
    <?php
        $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");
    
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
