<?php

namespace Model;

use DateTime;

class JsonFinder implements FinderInterface {

    public static $file = '../data/tweets.json'; // static car utilisé dans la creation de tweet pr last ID

    public function __construct() {
    }

    public function findAll() {
        $tweetsArray = array();
        $jsonFile = file_get_contents(self::$file);
        $tweets = json_decode($jsonFile, true);
        foreach($tweets["tweets"] as $tweet) {
            $tweet = new Tweet($tweet["id"], $tweet["user_id"], $tweet["content"], new DateTime($tweet["date"]["date"])); // car datetime est un tableau de 3 indices, avec le premier qui est date en string
            array_push($tweetsArray, $tweet);
        }
        return $tweetsArray;
    }

    public function findOneById($id) {
        $jsonFile = file_get_contents(self::$file);
        $tweets = json_decode($jsonFile, true);
        foreach($tweets["tweets"] as $tweet) {
            if($tweet["id"] == $id) {
                $tweetFound = new Tweet($tweet["id"], $tweet["user_id"], $tweet["content"], new DateTime($tweet["date"]["date"]));
                return $tweetFound;
            }
        }
    }

    public function saveTweet($tweet) {
        $jsonFile = file_get_contents(self::$file);
        $tweets = json_decode($jsonFile, true);
        foreach($tweets["tweets"] as $oneTweet) { // car l'indice du tableau n'est pas forcemment égale à l'id du tweet
            if($oneTweet["id"] == $tweet->getId()) {
                echo "L\'identifiant du tweet existe déjà !...";
                return;
            }
        }
        $tweetArray = array(
            "id" => $tweet->getId(),
            "user_id" => $tweet->getUserId(),
            "content" => $tweet->getContent(),
            "date" => $tweet->getDate(),
        );
        array_push($tweets["tweets"], $tweetArray);
        file_put_contents(self::$file, json_encode($tweets));
    }

    /*
     * EN JSON DERULO: pas de commentaires ! (dédice à monsieur imbert ! et ca rime xD)
     * on met ~2.0.1 car le 2 est la major release, le 0 est la version, le 1 est le bug fixe.
     * le ~ dit qu'on peut avoir les version de 2.0 à 2.x mais pas 3.x
     */
}