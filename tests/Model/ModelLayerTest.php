<?php

namespace Model;

use TestCase;
use MockConnection;
use DateTime;
use Model\TweetQuery;

class ModelLayerTest extends TestCase {

    public function setUp() {
    }

    public function testPersist() {
        $tweetQuery = new TweetQuery($this->getMock('MockConnection'));
        $tweetFindByOne = $tweetQuery->findOneById(10);
        $this->assertEquals(10, $tweetFindByOne->getId());
    }

}