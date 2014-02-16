<?php
    $tweets = $parameters['tweets'];
    include_once "header.php";
    $reflexion = new ReflectionClass('Model\Tweet');
?>
    <div id="content">
        <form action="/tweet">
            Limit <select name="limit"><option></option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option>
            </select>&nbsp;&nbsp;&nbsp;
            Order By <select name="orderBy" id="orderBy">
                <option></option>
                <?php
                    foreach($reflexion->getProperties() as $property) {
                        echo "<option value='" . $property->getName() . "'>" . $property->getName() . "</option>";
                    }
                ?>
            </select>&nbsp;&nbsp;&nbsp;
            <span id="direction" style="visibility:hidden">Direction <select name="direction"><option></option><option value="DESC">DESC</option><option value="ASC">ASC</option></select></span>
            <input id="searchForm" type="submit" value="Search">
        </form>
            <?php
            foreach($tweets as $tweet) {
                ?>
                <div class="tweet">
                    <span class="displayHeadTweet">
                        <?php echo "<a href='/tweet/" .$tweet->getId() . "'>" . $tweet->getId() . "</a>" ?>
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
                if($tweet !== end($tweets)) {
                    echo "<br/><div class='separation'></div><br/>";
                }
            }
            ?>
    </div>
<?php
    include_once "footer.php";
?>