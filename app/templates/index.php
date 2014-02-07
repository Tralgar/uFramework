<?php
    include_once "header.php";
?>

<div id="content">
    <h4>Bienvenue magueule, en direct du nouveau tweeter utilisant le framework officiel de Skippy.
    <br/>Toi aussi changes de camp et deviens serviteur de Skippy et de sa pensée richnou,
    elle seule te fera retrouver une totale liberté de pensée cosmique vers un nouvel age réminiscent... <br/>
    Alors Tweet ce que tu veux, tu es libre ! Mais avant, tu dois donner tout ce que tu possèdes au grand gourou Skippy.</h4>

    <form action="/tweet" method="POST">
        Id utilisateur :
        <input type="number" value="" name="user_id" /><br/>
        <div>Tweet :</div>
        <textarea type="text" value="" rows="3" cols="50" maxlength="140" name="content" size="140">Tapez le text de votre tweet</textarea>
        <input type="submit" style="" class="btn" value="Je valide !" />
    </form>
</div>

<?php
    include_once "footer.php";
?>