<html lang="fr">
    <head>
        <title>Framework Tweets by Léo & Léo</title>
        <link rel="stylesheet" type="text/css" href="/css/design.css" />
    </head>
    <body>
    <header>
            <?php

                if(session_status() === PHP_SESSION_ACTIVE && $_SESSION) {
                    echo "<h1 id='title'>" . $_SESSION['login'] . "</h1>";
                    echo '<a href="/logout" id="login">Log Out</a>';
                }
                else {
                    echo "<h1 id='title'>Anonymous</h1>";
                    echo '<a href="/login" id="login">Log In</a>';
                    echo '<a href="/signin" id="signin">Sign In</a>';
                }
            ?>
    </header>
    <a href="/new" id="addTweet">Add Tweet</a>
    <a href="/tweet" id="listTweets">List Tweets</a>
    <a href="https://github.com/Tralgar"><img style="position: absolute; width: 110px; top: 0; left: 0; border: 0;" src="/img/fork.png" alt="Fork me on GitHub"></a>
    <br/><br/>