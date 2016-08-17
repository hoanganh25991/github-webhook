<?php

$gitDirectories = [
	"laravel-embe-spending" => "embe-spends",
	"fabric-table-layout" => "fabric-table-layout"
];

$payload = file_get_contents('php://input');

try{
	$payloadObj = json_decode($payload, true);
	// $payloadObj = json_decode($payload);
}catch(\Exception $e){
	echo $payload;
	die;
}

$repositoryName = $payloadObj['repository']['name'];

$logFile = fopen("github-webhook.log", "w");

define(PHP_EOF, "\n");
$msgs = [];

chdir(__DIR__ . "/" . $repositoryName);
$msgs[] = getcwd();

$msgs[] = shell_exec("whoami");

$msgs[] = shell_exec("git pull origin master");

$msgs[] = date("Y-m-d H:i:s");

$msg = implode(PHP_EOF, $msgs);
fwrite($logFile, $msg);

fclose();

//send to slack
$slackUrl = "https://hooks.slack.com/services/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";

$channel = 

$params = array(
    "text" => $msg,
    "channel" => "#" . $channel,
    "username" => $username,
    "icon_url" => $icon_url
  );    
$params_string = "payload=" . json_encode($params);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $slackUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //don't verify SSL server
$result = curl_exec($ch);
curl_close($ch);

echo "success";
die;