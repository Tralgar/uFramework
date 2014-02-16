<?php
include_once "header.php";
?>

    <div id="contentForm">
        <form action="/signin" method="POST" id="loginForm">
            <div>Pseudo :
                <input type="text" value="" required="required" autofocus="autofocus" name="pseudo" /><br/><br/></div>
            <div>
                Nom :
                <input type="text" value="" required="required" name="name" /><br/><br/></div>
            <div>
                Password :
                <input type="password" value="" required="required" name="password" /><br/><br/></div>
            <input type="submit" class="save" id="saveFormLogin" value="Sign In" />
        </form>
    </div>

<?php
include_once "footer.php";
?>