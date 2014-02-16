<?php
$tweet = $parameters['tweet'];
include_once "header.php";
?>
    <div id="content">
        <div class="tweet">
                <span class="displayHeadTweet">
                    <?php echo $tweet->getId();?>
                    &nbsp;&nbsp;|&nbsp;&nbsp;User Id :
                    <?php echo $tweet->getUserId();?>
                </span>
                <span class="dateTweet">
                    <?php echo $tweet->getDate()->format("Y-m-d H:i:s");?>
                </span>
            <?php echo $tweet->getContent();?>
        </div>
        <?php
        include("deleteForm.php");
        ?>
    </div>
<?php
include_once "footer.php";
?>