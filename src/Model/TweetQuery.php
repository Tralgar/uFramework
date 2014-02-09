<?php

namespace Model;

use PDO;
use DateTime;
use Symfony\Component\Serializer\Exception\Exception;

class TweetQuery implements FinderInterface {

    private $connexion;

    public function __construct(PDO $connexion) {
        $this->connexion = $connexion;

    }

    public function findAll() {
        $query = $this->connexion->prepare('SELECT * FROM Tweet'); // exemple avec prepare, on aurait pu DESC mais on inverse apres pour la compatibilité JSON
        $query->execute();
        $tweets = array();
        foreach($query->fetchAll(PDO::FETCH_ASSOC) as $tweet) {
            array_push($tweets, new Tweet(intval($tweet['id']), intval($tweet['user_id']), $tweet['content'], new DateTime($tweet['date'])));
        }
        return $tweets;
    }

    public function findOneById($id) {
        $query = $this->connexion->query('SELECT * FROM Tweet WHERE id = "' . $id .'"');
        $query->setFetchMode(PDO::FETCH_OBJ);
        $tweet = $query->fetch(); // on utilise un objet stdClass
        return new Tweet(intval($tweet->id), intval($tweet->user_id), $tweet->content, new DateTime($tweet->date));
    }

    public function save($tweet) {
        $id = $tweet->getId();
        $user_id = $tweet->getUserId();
        $content = $tweet->getContent();
        $date = $tweet->getDate();

        var_dump($date);

        try {
            $this->connexion->exec('INSERT INTO Tweet VALUES (' . $id . ', ' . $user_id . ', "' . $content . '", "' . $date->date . '")'); // id auto généré mais pour essayer, je le gère moi même !
        }
        catch(Exception $e){
            $e->getMessage();
            exit;
        }
        return;
    }

    public function remove($id) {
        try {
            $this->connexion->exec('DELETE FROM Tweet WHERE id = ' . $id );
        }
        catch(Exception $e){
            $e->getMessage();
            exit;
        }
        return;
    }

    /*
    * Function that return the id of the last tweet + 1 to create a tweet with and auto ID unique
    */
    public function getLastTweetId() {
        $last = $this->connexion->query('SELECT MAX(id) FROM Tweet')->fetch()[0];
        return intval($last) + 1;
    }

}