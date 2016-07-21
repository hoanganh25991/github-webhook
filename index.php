<?php
// $payload = file_get_contents('php://input');
// $file = fopen("log.txt", "w");
// fwrite($file, $payload);
// fclose($payload);
// echo "success";

require(__DIR__ . "/vendor/autoload.php");

use GitHubWebhook\Handler;

//watch in /var/www/html to review
//how many RPOJECTS in
$gitDirectories = scandir("/var/www/html");


//remove on `.`, `..` result as directory
unset($gitDirectories[0]);
unset($gitDirectories[1]);

//loop through

$handler = new Handler("redocteam", __DIR__);
if($handler->handle()) {
    echo "OK";
} else {
    echo "Wrong secret";
}
