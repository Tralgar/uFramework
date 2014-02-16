<form action="/tweet/<?= $tweet->getId() ?>" method="POST">
    <input type="hidden" name="_method" value="DELETE" />
    <input class="delete" type="submit" Value="DELETE" />
</form>