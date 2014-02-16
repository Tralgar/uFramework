<?php

namespace Model;

use PDO;

class Connection extends PDO {

    public function __construct($PARAM_host, $PARAM_db, $PARAM_user, $PARAM_pwd) {
        parent::__construct('mysql:host=' . $PARAM_host . ';dbname=' . $PARAM_db, $PARAM_user, $PARAM_pwd);
    }

    public function executeQuery($query) {
        $queryPrepare = $this->prepare($query);
        $queryPrepare->execute();
        return $queryPrepare;
    }
}