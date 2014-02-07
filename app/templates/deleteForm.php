<form action="/tweet/<?= $tweet->getId() ?>" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <input class="btnDelete" src="img/delete.png" type="image" Value="submit" align="middle">
</form>