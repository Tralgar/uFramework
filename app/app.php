<?php

// Tous les controleurs

use Http\Request;
use Http\Response;
use Model\Tweet;
use Model\JsonDAO;
use Model\Connection;
use View\TemplateEngine;
use Assert\AssertionFailedException;
use Model\TweetQuery;
use Model\TweetMapper;
use Model\User;
use Model\UserQuery;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

require '../vendor/autoload.php';

// Partie PDO connection
$PARAM_host = 'localhost';
$PARAM_db = 'uframework';
$PARAM_user = 'uframework';
$PARAM_pwd = 'passw0rd';
$connection = new Connection($PARAM_host, $PARAM_db, $PARAM_user, $PARAM_pwd);

// Serialization (encodage/décodage)
$encoders = array(new JsonEncoder());
$normalizers = array(new GetSetMethodNormalizer());
$serializer = new Serializer($normalizers, $encoders);

$debug = true;
$app = new App(new TemplateEngine(__DIR__ . '/templates/'), $debug);

$app->get('/', function (Request $request) use ($app) { // request is not shared. It is always different !
    session_start();
    return $app->render('index.php');
});

$app->get('/new', function (Request $request) use ($app) {
    session_start();
    return $app->render('new.php');
});

$app->get('/tweet', function (Request $request) use ($app, $serializer, $connection) {
    session_start();
    // $inMemory = new \Model\InMemoryFinder();
    // $tweets = $inMemory->findAll();
    // $jsonTweets = new JsonDAO();
    // $tweets = $jsonTweets->findAll();
    $limit = $request->getParameter('limit');
    $orderBy = $request->getParameter('orderBy');
    $direction = $request->getParameter('direction');
    $tweetQuery = new TweetQuery($connection);
    $tweets = $tweetQuery->findAll($limit, $orderBy, $direction);
    $format = $request->guessBestFormat();
    if($format === 'json') {
        $response = new Response($serializer->serialize($tweets, $format), 200, array('Content-Type' => 'application/json'));
        $response->send();
        return;
    }
    return $app->render('tweets.php', array('tweets' => !$direction ? array_reverse($tweets, true) : $tweets, true)); // array_reverse pour affichage du dernier tweet en premier si il n'y pas de direction spécifié !
});

$app->get('/tweet/(\d+)', function (Request $request, $id) use ($app, $serializer, $connection) { // on peut request mais il faut le mettre en premier
    session_start();
    // $inMemory = new \Model\InMemoryFinder();
    // $tweet = $inMemory->findOneById($id);
    // $jsonTweets = new JsonDAO();
    // $jsonTweets->saveTweet(new \Model\Tweet(14, 2, "Tweet de test de creation", new DateTime())); // strtotime a voir : VU, strtotime("last Monday") mais renvoie timestamp, faut formater
    // $tweet = $jsonTweets->findOneById($id);
    $tweetQuery = new TweetQuery($connection);
    $tweet = $tweetQuery->findOneById($id);
    $format = $request->guessBestFormat();
    if($format === 'json') {
        $response = new Response($serializer->serialize($tweet, $format), 200, array('Content-Type' => 'application/json'));
        $response->send();
        return;
    }
    return $app->render('tweet.php', array('tweet' => $tweet));
});

$app->post('/tweet', function (Request $request) use ($app, $connection) {
    session_start();
    // Pour le test en curl, on a pas besoin de changer car on prend les parametres de la requete, ca ne change rien que ce soit du json ou pas, c'est géré avant !
    // $jsonTweets = new JsonDAO();
    $tweetQuery = new TweetQuery($connection);
    /*
    try {
        echo "ok";
        $tweet = new Tweet($tweetQuery->getLastTweetId(), intval($request->getParameter('user_id')), $request->getParameter('content'), new DateTime()); // intval cast en int car on test assert::interger sur la création du tweet
    } catch(AssertionFailedException $e) {
        echo $e->getMessage();
        exit;
    }
    $tweetQuery->save($tweet);
    */

    // TweetMapper
    $tweet = new Tweet();
    $tweet->setId($tweetQuery->getLastTweetId());
    $tweet->setUserId(intval($request->getParameter('user_id')));
    $tweet->setContent($request->getParameter('content'));
    $tweet->setDate(new DateTime());

    $mapper = new TweetMapper($connection);
    $mapper->persist($tweet);

    $app->redirect('/tweet');
});

$app->delete('/tweet/(\d+)', function (Request $request, $id) use ($app, $connection) {
    session_start();
    // $jsonTweets = new JsonDAO();
    // $jsonTweets->deleteTweet($id);
    $tweetQuery = new TweetQuery($connection);
    // $tweetQuery->remove($id);

    // Tweet Mapper
    $tweet = $tweetQuery->findOneById($id);

    $mapper = new TweetMapper($connection);
    $mapper->remove($tweet);

    $app->redirect('/tweet');
});

$app->get('/login', function (Request $request) use ($app) {
    session_start();
    if(session_status() === PHP_SESSION_ACTIVE && $_SESSION) {
        $app->redirect('/tweet');
    }
    return $app->render('login.php');
});

$app->post('/login', function (Request $request) use ($app, $connection) {
    $userQuery = new UserQuery($connection);
    $pseudo = $request->getParameter('pseudo');
    $password = $request->getParameter('password');
    if($userQuery->connect($pseudo, $password))
        $app->redirect('/tweet');
    $app->redirect('/login');
});

$app->post('/signin', function (Request $request) use ($app, $connection) {
    $userQuery = new UserQuery($connection);
    $pseudo = $request->getParameter('pseudo');
    $password = $request->getParameter('password');
    $name = $request->getParameter('name');
    if($pseudo && $password && $name) {
        $userQuery->save(new User($userQuery->getLastUserId(), $pseudo, $password, $name));
    }
    $app->redirect('/tweet');
});

$app->get('/signin', function (Request $request) use ($app) {
    session_start();
    if(session_status() === PHP_SESSION_ACTIVE && $_SESSION) {
        $app->redirect('/tweet');
    }
    return $app->render('signin.php');
});

$app->get('/logout', function (Request $request) use ($app) {
    session_start();
    session_destroy();
    $app->redirect('/tweet');
});

return $app;