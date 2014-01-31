<?php

use Http\Request;
use Model\Tweet;
use Model\JsonFinder;
use View\TemplateEngine;

// Tous les controleurs

require __DIR__ . '/../autoload.php';

$debug = true;

$app = new App(new TemplateEngine(__DIR__ . '/templates/'), $debug);

$app->get('/', function (Request $request) use ($app) { // request is not shared. It is always different !
    return $app->render('index.php');
});

$app->get('/tweet', function (Request $request) use ($app) {
    //$inMemory = new \Model\InMemoryFinder();
    //$tweets = $inMemory->findAll();
    $jsonTweets = new JsonFinder();
    $tweets = $jsonTweets->findAll();
    return $app->render('tweets.php', array('tweets' => $tweets));
});

$app->get('/tweet/(\d+)', function (Request $request, $id) use ($app) { // on peut request mais il faut le mettre en premier
    //$inMemory = new \Model\InMemoryFinder();
    //$tweet = $inMemory->findOneById($id);
    $jsonTweets = new JsonFinder();
    // $jsonTweets->saveTweet(new \Model\Tweet(14, 2, "Tweet de test de creation", new DateTime())); // strtotime a voir : VU, strtotime("last Monday") mais renvoie timestamp, faut formater
    $tweet = $jsonTweets->findOneById($id);
    return $app->render('tweet.php', array('tweet' => $tweet));
});

$app->post('/tweet', function (Request $request) use ($app) {
    $jsonTweets = new JsonFinder();
    $jsonTweets->saveTweet(new Tweet(Tweet::getLastTweetId(), intval($request->getParameter("user_id")), $request->getParameter("content"), new DateTime()));
    $app->redirect('/tweet', 201);
});

$app->delete('/tweet/(\d+)', function (Request $request, $id) use ($app) {
    $jsonTweets = new JsonFinder();
    $jsonTweets->deleteTweet($id);
    $app->redirect('/tweet', 204);
});

return $app;