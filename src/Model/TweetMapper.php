<?php

namespace Model;

use PDO;

class TweetMapper {

    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function persist(Tweet $tweet) {
        $id = $tweet->getId();
        $user_id = $tweet->getUserId();
        $content = $tweet->getContent();
        $date = $tweet->getDate();

        if(($id != null) & ($user_id != null) & ($content != null) & ($date != null)) {
            try {
                $query = $this->connection->prepare('INSERT INTO Tweet VALUES (:id, :user_id, :content, :date)');
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

        echo "Vous n'avez pas renseigné tous les champs obligatoires pour l'enregistrement d'un tweet !";
        exit;
    }

    public function remove(Tweet $tweet) {
        try {
            $query = $this->connection->prepare('DELETE FROM Tweet WHERE id = :id');
            $query->bindValue(":id", $tweet->getId(), PDO::PARAM_INT); // meme si ca sert a rien !
            $query->execute();
        }
        catch(Exception $e){
            $e->getMessage();
            exit;
        }
        return;
    }
}