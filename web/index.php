<?php
echo "##############################################################################";
echo "<p>Tests developpeurs : </p>";
echo "Current Path : " . getcwd();
echo "<br/>##############################################################################<br/>";

$app = require __DIR__ . '/../app/app.php';
$app->run();

register_shutdown_function(function ()
{
    print_r(get_included_files());
});
