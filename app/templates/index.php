<?php
    include_once "header.php";
?>

<h4>Bienvenue magueule, en direct du nouveau tweeter utilisant le framework officiel de skippy.
<br/>Toi aussi changes de camp et deviens serviteur de skippy et de sa pensée richnou,
elle seule te fera retrouver une totale liberté de pensée cosmique vers un nouvel age réminiscent... Here is SWAG !</h4>

<form action="/tweet" method="POST">
    Id utilisateur :
    <input type="number" value="" name="user_id" /><br/>
    Message :
    <input type="text" value="" name="content" size="140" />
    <input type="submit" class="btn" value="Et je valide !" />
</form>

<?php
    include_once "footer.php";
?>