<?php

namespace Model;

use Assert\Assertion;
// use Assert\AssertionFailedException; to display exception as i want :)

class Tweet {

    private $id;

    private $user_id;

    private $content;

    private $date;

    public function __construct($id, $user_id, $content, \DateTime $date) {

        Assertion::integer($id, "The id of the tweet must be an int.");
        $this->id = $id;
        Assertion::integer($user_id, "The user_id of the tweet must be an int.");
        $this->user_id = $user_id;
        Assertion::string($content, "The content of the tweet must be a string not empty.");
        $this->content = $content;

        // Pattern dateTime made by el Maestro
        // $pattern_date = '#^2[0-9]{3}[-]((0[1-9])|(1[0-2]))[-]((0[1-9])|(1|2[0-9])|(3[0-1]))[ ](((0|1)[0-9])|(2[0-3]))[:]((0[0-9])|([1-5][0-9]))[:]((0[0-9])|([1-5][0-9]))$#';
        // if(!preg_match($pattern_date, $date)) {
        //    echo "date pas bonne !";
        //    exit();
        //}
        $this->date = $date;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getContent() {
        return $this->content;
    }

    public function getDate() {
        return $this->date;
    }

    public function __toString() {
        return '<div><div class="titleTweet">User : ' . $this->user_id . '  | Date : ' . $this->date->format("Y-m-d H:i:s") . '<br/>' . $this->content . '</div><div></div>';
    }
}