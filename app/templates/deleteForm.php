<?php
    if(session_status() === PHP_SESSION_ACTIVE && $_SESSION) {
        if($_SESSION['id'] == $tweet->getUserId()) {
?>

<form action="/tweet/<?= $tweet->getId() ?>" method="POST">
    <input type="hidden" name="_method" value="DELETE" />
    <input class="delete" type="submit" Value="DELETE" />
</form>

<?php } } ?>
