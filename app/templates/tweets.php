<?php
    $tweets = $parameters['tweets'];
    include_once "header.php";
?>
        <div class="titleTweets">
            Affichage des tweets :
        </div>
        <br/><br/>
        <div>
            <?php
            foreach($tweets as $tweet) {
                echo $tweet;
            }
            ?>
        </div>
<?php
    include_once "footer.php";
?>