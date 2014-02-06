<?php

// Tous les controleurs

use Http\Request;
use Http\Response;
use Model\Tweet;
use Model\JsonDAO;
use View\TemplateEngine;
use Assert\AssertionFailedException;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

require '../vendor/autoload.php';

// Serialization (encodage/décodage)
$encoders = array(new JsonEncoder());
$normalizers = array(new GetSetMethodNormalizer());
$serializer = new Serializer($normalizers, $encoders);

$debug = true;
$app = new App(new TemplateEngine(__DIR__ . '/templates/'), $debug);

$app->get('/', function (Request $request) use ($app) { // request is not shared. It is always different !
    return $app->render('index.php');
});

$app->get('/tweet', function (Request $request) use ($app, $serializer) {
    //$inMemory = new \Model\InMemoryFinder();
    //$tweets = $inMemory->findAll();
    $jsonTweets = new JsonDAO();
    $tweets = $jsonTweets->findAll();
    $format = $request->guessBestFormat();
    if($format === 'json') {
        $response = new Response($serializer->serialize($tweets, $format), 200, array('Content-Type' => 'application/json'));
        $response->send();
        return;
    }
    return $app->render('tweets.php', array('tweets' => array_reverse($tweets, true))); // array_reverse pour affichage du dernier tweet en premier !
});

$app->get('/tweet/(\d+)', function (Request $request, $id) use ($app, $serializer) { // on peut request mais il faut le mettre en premier
    //$inMemory = new \Model\InMemoryFinder();
    //$tweet = $inMemory->findOneById($id);
    $jsonTweets = new JsonDAO();
    // $jsonTweets->saveTweet(new \Model\Tweet(14, 2, "Tweet de test de creation", new DateTime())); // strtotime a voir : VU, strtotime("last Monday") mais renvoie timestamp, faut formater
    $tweet = $jsonTweets->findOneById($id);
    $format = $request->guessBestFormat();
    if($format === 'json') {
        $response = new Response($serializer->serialize($tweet, $format), 200, array('Content-Type' => 'application/json'));
        $response->send();
        return;
    }
    return $app->render('tweet.php', array('tweet' => $tweet));
});

$app->post('/tweet', function (Request $request) use ($app) {
    // Pour le test en curl, on a pas besoin de changer car on prend les parametres de la requete, ca ne change rien que ce soit du json ou pas, c'est géré avant !
    $jsonTweets = new JsonDAO();
    try {
        $tweet = new Tweet($jsonTweets->getLastTweetId(), intval($request->getParameter('user_id')), $request->getParameter('content'), new DateTime()); // intval cast en int car on test assert::interger sur la création du tweet
    } catch(AssertionFailedException $e) {
        echo $e->getMessage();
        exit;
    }
    $jsonTweets->saveTweet($tweet);
    $app->redirect('/tweet');
});

$app->delete('/tweet/(\d+)', function (Request $request, $id) use ($app) {
    $jsonTweets = new JsonDAO();
    $jsonTweets->deleteTweet($id);
    $app->redirect('/tweet');
});

return $app;