<?php

namespace Model;

// i called it TweetQuery because it's not only a finder, and propel name it like that as i saw =D

use PDO;
use DateTime;
use Symfony\Component\Serializer\Exception\Exception;
use ReflectionClass;

class TweetQuery implements FinderInterface {

    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function findAll($limit = null, $orderBy = null, $direction = null) {
        $queryString = "SELECT * FROM Tweet";
        if($orderBy) {
            $reflexion = new ReflectionClass('Model\Tweet');
            foreach($reflexion->getProperties() as $property) {
                if($property->getName() === $orderBy) {
                    $queryString .= " ORDER BY " . $orderBy;
                    if($direction && ($direction === "ASC" || $direction === "DESC")) {
                        $queryString .= " " . $direction;
                    }
                    break;
                }
            }
        }
        if($limit) {
            $queryString .= " LIMIT " . $limit;
        }

        $query = $this->connection->executeQuery($queryString); // Exemple d'utlisation d'une prepare query via connection

        if(!$query) {
            return $queryString;
        }

        $tweets = array();
        foreach($query->fetchAll(PDO::FETCH_ASSOC) as $tweet) {
            array_push($tweets, new Tweet(intval($tweet['id']), intval($tweet['user_id']), $tweet['content'], new DateTime($tweet['date'])));
        }
        return $tweets;
    }

    public function findOneById($id) {
        $query = $this->connection->query('SELECT * FROM Tweet WHERE id = "' . $id .'"');
        $query->setFetchMode(PDO::FETCH_OBJ);
        $tweet = $query->fetch(); // on utilise un objet stdClass
        return new Tweet(intval($tweet->id), intval($tweet->user_id), $tweet->content, new DateTime($tweet->date));
    }

    public function save(Tweet $tweet) {
        if($tweet instanceof Tweet) { // utilisation instanceof pour essaie
            $id = $tweet->getId();
            $user_id = $tweet->getUserId();
            $content = $tweet->getContent();
            $date = $tweet->getDate();

            if(($id != null) & ($user_id != null) & ($content != null) & ($date != null)) {
                try {
                    $query = $this->connection->prepare('INSERT INTO Tweet VALUES (:id, :user_id, :content, :date)'); // id auto généré mais pour essayer, je le gère moi même !
                    $query->bindValue(":id", $id, PDO::PARAM_INT);
                    $query->bindValue(":user_id", $user_id, PDO::PARAM_INT);
                    $query->bindValue(":content", $content, PDO::PARAM_STR);
                    $query->bindValue(":date", $date->format("Y-m-d H:i:s"));
                    $query->execute();
                    return;
                }
                catch(Exception $e){
                    echo $e->getMessage();
                    exit;
                }
            }
        }

        echo "Vous n'avez pas renseigné tous les champs obligatoires pour l'enregistrement d'un tweet !";
        return;
    }

    public function remove($id) {
        try {
            $query = $this->connection->prepare('DELETE FROM Tweet WHERE id = :id');
            $query->bindValue(":id", $id, PDO::PARAM_INT); // meme si ca sert a rien ! car c'est typehinter et vérifié avant
            $query->execute();
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
        $last = $this->connection->query('SELECT MAX(id) FROM Tweet')->fetch()[0];
        return intval($last) + 1;
    }

}