<?php

namespace Model;

class Tweet {

    private $id;

    private $user_id;

    private $content;

    private $date;

    public function __construct($id, $user_id, $content, $date) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->content = $content;
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
        return '<div><div class="titleTweet">User : ' . $this->user_id . '  | Date : ' . $this->date . '<br/>' . $this->content . '</div><div></div>';
    }

}