<?php

namespace Model;

class JsonFinder implements FinderInterface {

    private $file;

    public function __construct() {
        $this->file = '../data/tweets.json';
    }

    public function findAll() {
        $tweetsArray = array();
        $jsonFile = file_get_contents($this->file);
        $tweets = json_decode($jsonFile, true);
        foreach($tweets["tweets"] as $tweet) {
            $tweet = new Tweet($tweet["id"], $tweet["user_id"], $tweet["content"], new \DateTime($tweet["date"]["date"])); // car datetime est un tableau de 3 indices, avec le premier qui est date en string
            array_push($tweetsArray, $tweet);
        }
        return $tweetsArray;
    }

    public function findOneById($id) {
        $jsonFile = file_get_contents($this->file);
        $tweets = json_decode($jsonFile, true);
        foreach($tweets["tweets"] as $tweet) {
            if($tweet["id"] == $id) {
                $tweetFound = new Tweet($tweet["id"], $tweet["user_id"], $tweet["content"], new \DateTime($tweet["date"]["date"]));
                return $tweetFound;
            }
        }
    }

    public function saveTweet($tweet) {
        $jsonFile = file_get_contents($this->file);
        $tweets = json_decode($jsonFile, true);
        if(!$tweets["tweets"][$tweet->getId()])
        {
            $tweetArray = array(
                "id" => $tweet->getId(),
                "user_id" => $tweet->getUserId(),
                "content" => $tweet->getContent(),
                "date" => $tweet->getDate(),
            );
            array_push($tweets["tweets"], $tweetArray);
            file_put_contents($this->file, json_encode($tweets));
        }

        echo "id raté";
        exit(); // erreur d'id non identifiant
    }

    /*
     * EN JSON DERULO: pas de commentaires ! (dédice à monsieur imbert ! et ca rime xD)
     * on met ~2.0.1 car le 2 est la major release, le 0 est la version, le 1 est le bug fixe.
     * le ~ dit qu'on peut avoir les version de 2.0 à 2.x mais pas 3.x
     */
}