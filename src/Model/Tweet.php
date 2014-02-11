<?php

namespace Model;

use Assert\Assertion;
use DateTime;
// use Assert\AssertionFailedException; to display exception as i want :)

class Tweet {

    private $id;

    private $user_id;

    private $content;

    private $date;

    /** Explications :
     *  Au départ, il n'y avait pas de setter, puis pour le data Mapper, j'en ai créé et pour éviter
     *  la duplication de code, je les utilise dans le constructeur. Comme il faut aussi créer un objet vide à la base,
     *  et qu'on ne peut pas créer deux méthode construct, je met un if pour voir si tout est renseigné ou non.
     */

    public function __construct($id = null, $user_id = null, $content = null, DateTime $date = null) {
        if($id != null & $user_id != null & $content != null & $date != null) { // test constructeur totalement renseigné
            $this->setId($id);
            $this->setUserId($user_id);
            $this->setContent($content);
            $this->setDate($date);
            // $pattern_datetime = '#^2[0-9]{3}[-]((0[1-9])|(1[0-2]))[-]((0[1-9])|(1|2[0-9])|(3[0-1]))[ ](((0|1)[0-9])|(2[0-3]))[:]((0[0-9])|([1-5][0-9]))[:]((0[0-9])|([1-5][0-9]))$#';
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        Assertion::integer($id, "The id of the tweet must be an int.");
        $this->id = $id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        Assertion::integer($user_id, "The user_id of the tweet must be an int.");
        $this->user_id = $user_id;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        Assertion::string($content, "The content of the tweet must be a string not empty.");
        $this->content = $content;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate(DateTime $date) {
        $this->date = $date;
    }

    public function __toString() {
        return '<div>Tweet : ' . $this->getId() . '  | User : ' . $this->getUserId() . '  | Date : ' . $this->getDate()->format("Y-m-d H:i:s") . '<br/>' . $this->getContent() . '</div>';
    }

}