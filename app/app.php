<?php

// Tous les controleurs

use Http\Request;
use Http\Response;
use Model\Tweet;
use Model\JsonDAO;
use View\TemplateEngine;
use Assert\AssertionFailedException;
use Model\TweetQuery;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

require '../vendor/autoload.php';

// Partie PDO connexion
$PARAM_host = 'localhost';
$PARAM_port = '3306';
$PARAM_db = 'uframework';
$PARAM_user = 'uframework';
$PARAM_pwd = 'passw0rd';
try {
    $connexion = new PDO('mysql:host='.$PARAM_host.';dbname='.$PARAM_db, $PARAM_user, $PARAM_pwd);
}
catch (Exception $e) {
    echo("Erreur lors de la connexion à la database") . $e->getMessage();
    exit;
}


// Serialization (encodage/décodage)
$encoders = array(new JsonEncoder());
$normalizers = array(new GetSetMethodNormalizer());
$serializer = new Serializer($normalizers, $encoders);

$debug = true;
$app = new App(new TemplateEngine(__DIR__ . '/templates/'), $debug);

$app->get('/', function (Request $request) use ($app) { // request is not shared. It is always different !
    return $app->render('index.php');
});

$app->get('/tweet', function (Request $request) use ($app, $serializer, $connexion) {
    // $inMemory = new \Model\InMemoryFinder();
    // $tweets = $inMemory->findAll();
    // $jsonTweets = new JsonDAO();
    // $tweets = $jsonTweets->findAll();
    $tweetQuery = new TweetQuery($connexion);
    $tweets = $tweetQuery->findAll();
    $format = $request->guessBestFormat();
    if($format === 'json') {
        $response = new Response($serializer->serialize($tweets, $format), 200, array('Content-Type' => 'application/json'));
        $response->send();
        return;
    }
    return $app->render('tweets.php', array('tweets' => array_reverse($tweets, true))); // array_reverse pour affichage du dernier tweet en premier !
});

$app->get('/tweet/(\d+)', function (Request $request, $id) use ($app, $serializer, $connexion) { // on peut request mais il faut le mettre en premier
    // $inMemory = new \Model\InMemoryFinder();
    // $tweet = $inMemory->findOneById($id);
    // $jsonTweets = new JsonDAO();
    // $jsonTweets->saveTweet(new \Model\Tweet(14, 2, "Tweet de test de creation", new DateTime())); // strtotime a voir : VU, strtotime("last Monday") mais renvoie timestamp, faut formater
    // $tweet = $jsonTweets->findOneById($id);
    $tweetQuery = new TweetQuery($connexion);
    $tweet = $tweetQuery->findOneById($id);
    $format = $request->guessBestFormat();
    if($format === 'json') {
        $response = new Response($serializer->serialize($tweet, $format), 200, array('Content-Type' => 'application/json'));
        $response->send();
        return;
    }
    return $app->render('tweet.php', array('tweet' => $tweet));
});

$app->post('/tweet', function (Request $request) use ($app, $connexion) {
    // Pour le test en curl, on a pas besoin de changer car on prend les parametres de la requete, ca ne change rien que ce soit du json ou pas, c'est géré avant !
    // $jsonTweets = new JsonDAO();
    $tweetQuery = new TweetQuery($connexion);
    try {
        $tweet = new Tweet($tweetQuery->getLastTweetId(), intval($request->getParameter('user_id')), $request->getParameter('content'), new DateTime()); // intval cast en int car on test assert::interger sur la création du tweet
    } catch(AssertionFailedException $e) {
        echo $e->getMessage();
        exit;
    }
    $tweetQuery->save($tweet);
    $app->redirect('/tweet');
});

$app->delete('/tweet/(\d+)', function (Request $request, $id) use ($app, $connexion) {
    // $jsonTweets = new JsonDAO();
    // $jsonTweets->deleteTweet($id);
    $tweetQuery = new TweetQuery($connexion);
    $tweetQuery->remove($id);
    $app->redirect('/tweet');
});

return $app;