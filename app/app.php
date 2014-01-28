<?php


use Http\Request;
// Tous les controleurs

require __DIR__ . '/../autoload.php';

$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

$app->get('/', function (Request $request) use ($app) {// request is not shared. It is always different !
    return $app->render('index.php');
});

$app->get('/tweet', function (Request $request) use ($app) {
    //$inMemory = new \Model\InMemoryFinder();
    //$tweets = $inMemory->findAll();
    $jsonTweets = new \Model\JsonFinder();
    $tweets = $jsonTweets->findAll();
    return $app->render('tweets.php', array('tweets' => $tweets));
});

$app->get('/tweet/(\d+)', function (Request $request, $id) use ($app) { // on peut request mais il faut le mettre en premier
    //$inMemory = new \Model\InMemoryFinder();
    //$tweet = $inMemory->findOneById($id);
    $jsonTweets = new \Model\JsonFinder();
    // $jsonTweets->saveTweet(new \Model\Tweet(14, 2, "Tweet de test de creation", new DateTime())); // strtotime a voir : VU, strtotime("last Monday") mais renvoie timestamp, faut formater
    $tweet = $jsonTweets->findOneById($id);
    return $app->render('tweet.php', array('tweet' => $tweet));
});

return $app;
