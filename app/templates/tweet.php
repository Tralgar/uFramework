<?php
    $tweet = $parameters['tweet'];
    include_once "header.php";
?>
        <div class="titleTweets">
            Affichage du tweet :
        </div>
        <br/><br/>
        <div>
            <form style="float:left;" action="/tweet/<?php echo $tweet->getId() ?>" method="DELETE">
                <input type="hidden" name="id" />
                <input type="submit" value="Supprimer" />
            </form>
        <?php
            echo $tweet;
        ?>
        </div>

<?php
    include_once "footer.php";
?>