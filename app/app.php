<?php

require __DIR__ . '/../autoload.php';

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

$app->get('/', function () use ($app) {
    return $app->render('index.php');
});

//$app->get('/uframework/web/', function () use ($app) {
//    return $app->render('leo.php');
//});

// ...

return $app;
