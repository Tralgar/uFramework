<?php

namespace Model;

use Exception\HttpException;

class InMemoryFinder implements FinderInterface {

    private $inMemory = array();

    public function __construct() {
        $tweet1 = new Tweet(1, 1, "salut je suis le premier tweet du maestro", date("Y-m-d H:i:s"));
        $tweet2 = new Tweet(2, 1, "Second tweet du maestro", date("Y-m-d H:i:s"));
        $tweet3 = new Tweet(3, 6, "Tweet du 8eme user", date("Y-m-d H:i:s"));
        array_push($this->inMemory, $tweet1);
        array_push($this->inMemory, $tweet2);
        array_push($this->inMemory, $tweet3);
    }

    public function findAll() {
        return $this->inMemory;
    }

    public function findOneById($id) {
        foreach($this->inMemory as $tweet) {
            if($tweet->getId() == $id) {
                return $tweet;
            }
        }

        throw new HttpException(404, 'Page Not Found, wrong Tweet ID !');
    }
}