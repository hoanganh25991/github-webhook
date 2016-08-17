<?php

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

$msgs = [];

$map = [];

$projectFolder = $repositoryName;
//if $repository contains "laravel", remove it
$projectFolder = str_replace("laravel-", "", $repositoryName);
//deal with special case
if(isset($map[$repositoryName])){
	$projectFolder = $map[$repositoryName];
}

echo $projectFolder;

chdir(__DIR__ . "/" . $projectFolder);
$msgs[] = getcwd();

echo shell_exec("whoami");

echo shell_exec("git stash");

echo shell_exec("git pull origin master");

echo date("Y-m-d H:i:s");

if($repositoryName == "fabric-table-layout"){
	echo "fabric-table-layout repository need NPM";
	//www-data added to visudo
	//www-data    ALL=NOPASSWD: /usr/bin/npm
	//this means that www-data can run
	//SUDO NPM INSTALL
	//without prompt sudo password
	//NPM MUST BE RUN BY SUDO
	//update if some change on package.json
	echo shell_exec("sudo npm install");
	//compile file
	echo shell_exec("gulp");
}

$msg = implode("\n", $msgs);
fwrite($logFile, $msg);

fclose($logFile);



echo "success";
die;