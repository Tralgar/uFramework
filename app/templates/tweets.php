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
                <form style="float:left;" action="/tweet" method="DELETE">
                    <input type="hidden" name="id" />
                    <input type="submit" value="Supprimer" />
                </form>
                <?php
                echo $tweet;
            }
            ?>
        </div>
<?php
    include_once "footer.php";
?>