<?php
include_once "header.php";
?>

    <div id="contentForm">
        <form action="/login" method="POST" id="loginForm">
            <div>Pseudo :
            <input type="text" value="" required="required" autofocus="autofocus" name="pseudo" /><br/><br/></div>
            <div>
            Password :
            <input type="password" value="" required="required" name="password" /><br/><br/></div>
            <input type="submit" class="save" id="saveFormLogin" value="Log In" />
        </form>
    </div>

<?php
include_once "footer.php";
?>