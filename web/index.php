<?php

$app = require __DIR__ . '/../app/app.php';

echo "###################################### SERVER ######################################<br/>";
print_r($_SERVER);

$app->run();

echo "###################################### INCLUDES ######################################<br/>";
register_shutdown_function(function ()
{
    print_r(get_included_files());
});
