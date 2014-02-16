<?php

namespace Model;

use TestCase;

class ModelLayerTest extends TestCase {

    private $connection;

    public function setUp() {
        $this->connection = $this->getMock('Model\MockConnection');
    }

    public function testFindAllTweet() {
        $tweetQuery = new TweetQuery($this->connection);

        $query = $tweetQuery->findAll();
        $this->assertEquals("SELECT * FROM Tweet", $query);

        $queryLimit = $tweetQuery->findAll(5);
        $this->assertEquals("SELECT * FROM Tweet LIMIT 5", $queryLimit);

        $queryOrder = $tweetQuery->findAll(null, id);
        $this->assertEquals("SELECT * FROM Tweet ORDER BY id", $queryOrder);

        $queryAll = $tweetQuery->findAll(20, user_id, "DESC");
        $this->assertEquals("SELECT * FROM Tweet ORDER BY user_id DESC LIMIT 20", $queryAll);

        $queryBadOrder = $tweetQuery->findAll(null, propertyNotExist);
        $this->assertNotEquals("SELECT * FROM Tweet ORDER BY propertyNotExist", $queryAll);
    }



}