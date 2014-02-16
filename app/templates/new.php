<?php
include_once "header.php";
?>

    <div id="content">
        <form action="/tweet" method="POST">
            User Id
            <input type="number" value="" min="1" required="required" autofocus="autofocus" id="newUserId" name="user_id" /><br/><br/>
            <div>Tweet</div>
            <textarea type="text" value="" rows="3" cols="50" maxlength="140" name="content" size="140">Write your Tweet</textarea><br/><br/>
            <input type="submit" class="save" value="Save" />
        </form>
    </div>

<?php
include_once "footer.php";
?>