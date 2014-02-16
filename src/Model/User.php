<?php

namespace Model;

use Assert\Assertion;

class User {

    private $id;

    private $pseudo;

    private $password;

    private $name;

    public function __construct($id, $pseudo, $password, $name) {
        $this->setId($id);
        $this->setPseudo($pseudo);
        $this->setPassword($password);
        $this->setName($name);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        Assertion::integer($id, "The id of the user must be an int.");
        $this->id = $id;
    }

    public function getPseudo() {
        return $this->pseudo;
    }

    public function setPseudo($pseudo) {
        Assertion::string($pseudo, "The pseudo must be a string not empty.");
        $this->pseudo = $pseudo;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        Assertion::string($password, "The password must be a string not empty.");
        $this->password = $password;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        Assertion::string($name, "The name must be a string not empty.");
        $this->name = $name;
    }

}