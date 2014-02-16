<?php

namespace Model;

use PDO;
use DateTime;
use Symfony\Component\Serializer\Exception\Exception;

class UserQuery {

    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function save(User $user) {
        if($user instanceof User) { // utilisation instanceof pour essaie
            $id = $user->getId();
            $pseudo = $user->getPseudo();
            $password = $user->getPassword();
            $name = $user->getName();

            if(($id != null) & ($pseudo != null) & ($password != null) & ($name != null)) {
                try {
                    $query = $this->connection->query('SELECT * FROM User WHERE pseudo = "' . $pseudo . '"');
                    $query->setFetchMode(PDO::FETCH_OBJ);
                    if($query->fetch()) {
                        echo "Pseudo existant";
                    }

                    $query = $this->connection->prepare('INSERT INTO User VALUES (:id, :pseudo, :password, :name)'); // id auto généré mais pour essayer, je le gère moi même !
                    $query->bindValue(":id", $id, PDO::PARAM_INT);
                    $query->bindValue(":pseudo", $pseudo, PDO::PARAM_INT);
                    $query->bindValue(":password", $password, PDO::PARAM_STR);
                    $query->bindValue(":name", $name, PDO::PARAM_STR);
                    $query->execute();
                    session_start();
                    session_regenerate_id();
                    $_SESSION['login'] = $pseudo;
                    $_SESSION['id'] = $id;
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

    public function connect($pseudo, $password) {
        $query = $this->connection->query('SELECT * FROM User WHERE pseudo = "' . $pseudo .'" AND password = "' . $password . '"');
        $query->setFetchMode(PDO::FETCH_OBJ);
        $user = $query->fetch(); // on utilise un objet stdClass
        if($user) {
            session_start();
            session_regenerate_id();
            $_SESSION['login'] = $user->pseudo;
            $_SESSION['id'] = $user->id;
            return true;
        }
        return false;
    }

    public function getLastUserId() {
        $last = $this->connection->query('SELECT MAX(id) FROM User')->fetch()[0];
        return intval($last) + 1;
    }

}