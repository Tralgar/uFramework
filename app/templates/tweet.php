<?php
    $tweet = $parameters['tweet'];
    include_once "header.php";
?>
        <div class="titleTweets">
            Affichage du tweet :
        </div>
        <br/><br/>
        <div>
            <?php
                echo $tweet;
            ?>
        </div>

<?php
    include_once "footer.php";
?>