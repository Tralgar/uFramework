<?php
    $tweets = $parameters['tweets'];
?>
<html>
    <body>
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
    </body>
</html>