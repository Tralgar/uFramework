<?php

// Tous les controleurs

require __DIR__ . '/../autoload.php';

$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

$app->get('/', function () use ($app) {
    return $app->render('index.php');
});

$app->get('/tweet', function () use ($app) {
    //$inMemory = new \Model\InMemoryFinder();
    //$tweets = $inMemory->findAll();
    $jsonTweets = new \Model\JsonFinder();
    $tweets = $jsonTweets->findAll();
    return $app->render('tweets.php', array('tweets' => $tweets));
});

$app->get('/tweet/(\d+)', function ($id) use ($app) { // on peut request mais il faut le mettre en premier
    //$inMemory = new \Model\InMemoryFinder();
    //$tweet = $inMemory->findOneById($id);
    $jsonTweets = new \Model\JsonFinder();
    $jsonTweets->saveTweet(new \Model\Tweet(3, 6, "Tweet du 8eme user", new DateTime("now"))); // strtotime a voir
    $tweet = $jsonTweets->findOneById($id);
    return $app->render('tweet.php', array('tweet' => $tweet));
});

return $app;
