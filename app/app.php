<?php

require __DIR__ . '/../autoload.php';

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);


// / racine mais il faudrait /uframework/web/
$app->get('/', function () use ($app) {
    return $app->render('index.php');
});

// ...

return $app;
