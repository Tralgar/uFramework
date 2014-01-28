<?php
    include_once "header.php";
?>
<h1>Hello, World! It Works, vous êtes sur le framework officiel des adorateurs de la pensée richnou qui transmet une totale libertée de penser vers un nouvelle age réminiscent...</h1>

<form action="/tweet" method="POST">
    Id utilisateur :
    <input type="number" value="" name="user_id"/><br/>
    Message :
    <input type="text" value="" name="content"/>
    <input type="submit" value="Et je valide !" />
</form>

<?php
    include_once "footer.php";
?>