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
                ?>
                <form style="float:left;" action="/tweet/<?= $tweet->getId() ?>" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="submit" value="Extermination du tweet" />
                </form>
                <?php
                echo $tweet;
            }
            ?>
        </div>
<?php
    include_once "footer.php";
?>