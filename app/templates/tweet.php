<?php
    $tweet = $parameters['tweet'];
    include_once "header.php";
?>
    <div id="content">
        <div class="titleTweets">
            Affichage du Tweet :
        </div>
        <div id="contentTweet">
        <?php
            include("deleteForm.php");
            echo $tweet;
        ?>
        </div>
    </div>

<?php
    include_once "footer.php";
?>