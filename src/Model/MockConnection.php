<?php

namespace Model;

class MockConnection extends Connection
{
    // Classe créée ici car si je la crée dans les tests, ca ne marche pas comme expliqué lors des mails

    public function __construct()
    { }

    public function executeQuery($query) {
        return $query;
    }
}