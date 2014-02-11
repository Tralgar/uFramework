<?php

namespace Model;

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
                var_dump($date);
                $this->connection->exec('INSERT INTO Tweet VALUES (' . $id . ', ' . $user_id . ', "' . $content . '", "' . $date->date . '")'); // id auto généré mais pour essayer, je le gère moi même !
                return;
            }
            catch(Exception $e){
                $e->getMessage();
                exit;
            }
        }

        echo "Vous n'avez pas renseigné tous les champs obligatoires pour l'enregistrement d'un tweet !";
        exit;
    }

    public function remove(Tweet $tweet) {
        try {
            $this->connection->exec('DELETE FROM Tweet WHERE id = ' . $tweet->getId());
        }
        catch(Exception $e){
            $e->getMessage();
            exit;
        }
        return;
    }
}