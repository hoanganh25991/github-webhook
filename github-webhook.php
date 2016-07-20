<?php
$payload = file_get_contents('php://input');
$file = fopen("log.txt", "w");
fwrite($file, $payload);
fclose($payload);
echo "success";
