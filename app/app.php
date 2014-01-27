<?php

require __DIR__ . '/../autoload.php';

$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

$app->get('/', function () use ($app) {
    return $app->render('index.php');
});

$app->get('/tweet', function () use ($app) {
    $inMemory = new \Model\InMemoryFinder();
    $tweets = $inMemory->findAll();
    return $app->render('tweets.php', array('tweets' => $tweets));
});

$app->get('/tweet/(\d+)', function ($id) use ($app) {
    $inMemory = new \Model\InMemoryFinder();
    $tweet = $inMemory->findOneById($id);
    return $app->render('tweet.php', array('tweet' => $tweet));
});

return $app;
