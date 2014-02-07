<?php
    $tweets = $parameters['tweets'];
    include_once "header.php";
?>
    <div id="content">
        <div class="titleTweets">
            Affichage des Tweets
        </div>
        <div>
            <?php
            foreach($tweets as $tweet) {
                include("deleteForm.php");
                echo $tweet;
                if($tweet !== end($tweets)) {
                    echo "<div class='separation'></div>";
                }
            }
            ?>
        </div>
    </div>
<?php
    include_once "footer.php";
?>