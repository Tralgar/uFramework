<?php

namespace Model;

use DateTime;
use Exception\HttpException;

class JsonDAO implements FinderInterface {

    public static $file = '../data/tweets.json'; // static car utilisé dans la creation de tweet pr last ID

    public function __construct() {}

    public function findAll() {
        $tweetsArray = array();
        $tweets = $this->getJsonTweets();
        foreach($tweets['tweets'] as $tweet) {
            $tweet = new Tweet($tweet['id'], $tweet['user_id'], $tweet['content'], new DateTime($tweet['date']['date'])); // car datetime est un tableau de 3 indices, avec le premier qui est date en string
            array_push($tweetsArray, $tweet);
        }
        return $tweetsArray;
    }

    public function findOneById($id) {
        $tweets = $this->getJsonTweets();
        foreach($tweets['tweets'] as $tweet) {
            if($tweet['id'] == $id) {
                $tweetFound = new Tweet($tweet['id'], $tweet['user_id'], $tweet['content'], new DateTime($tweet['date']['date']));
                return $tweetFound;
            }
        }
    }

    public function saveTweet($tweet) {
        $tweets = $this->getJsonTweets();
        foreach($tweets['tweets'] as $oneTweet) { // car l'indice du tableau n'est pas forcemment égale à l'id du tweet
            if($oneTweet['id'] == $tweet->getId()) {
                echo "L\'identifiant du tweet existe déjà !...";
                return;
            }
        }
        $tweetArray = array(
            'id' => $tweet->getId(),
            'user_id' => $tweet->getUserId(),
            'content' => $tweet->getContent(),
            'date' => $tweet->getDate(),
        );
        array_push($tweets['tweets'], $tweetArray);
        $this->setJsonTweets($tweets);
        return;
    }

    public function deleteTweet($id) {
        if($tweet = $this->findOneById($id)) {
            $tweets = $this->getJsonTweets();
            foreach($tweets['tweets'] as $key => $tweet) {
                if ($tweet['id'] == $id) {
                    unset($tweets['tweets'][$key]);
                }
            }
            $this->setJsonTweets($tweets);
            return;
        }

        throw new HttpException(404, "Le tweet avec l'id demandé n'existe pas !");
    }

    private function getJsonTweets() { // On est SOLID, ON ÉVITE LA DUPLICATION DE CODE
        $tweets = json_decode(file_get_contents(self::$file), true);
        if($tweets === false) {
            echo "Erreur lors de la lecture du fichier " . self::$file;
            exit();
        }
        return $tweets;
    }

    private function setJsonTweets($tweets) {
        if(file_put_contents(self::$file, json_encode($tweets)) === false) {
            echo "Erreur lors de l'écriture dans le fichier " . self::$file;
            exit;
        }
        return;
    }


    // DECHARGER LA CLASSE TWEET DE SAVOIR LE LAST ID
    /*
     * Function that return the id of the last tweet + 1 to create a tweet with and auto ID unique
     */
    public function getLastTweetId() {
        $jsonFile = file_get_contents(JsonDAO::$file);
        $tweets = json_decode($jsonFile, true);
        $lastTweet = end($tweets['tweets']);
        return $lastTweet['id'] + 1;
    }

    /*
     * EN JSON DERULO: pas de commentaires ! (dédice à monsieur imbert ! et ca rime xD)
     * on met ~2.0.1 car le 2 est la major release, le 0 est la version, le 1 est le bug fixe.
     * le ~ dit qu'on peut avoir les version de 2.0 à 2.x mais pas 3.x
     */
}