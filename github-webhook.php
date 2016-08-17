<?php
$msgs = [];

function _echo($msg){
	$msgs[] = $msg;
	echo $msg;
	echo "\r\n";
}

$payload = file_get_contents('php://input');

try{
  $payloadObj = json_decode($payload, true);
  // $payloadObj = json_decode($payload);
}catch(\Exception $e){
  _echo($payload);
  die;
}

$repositoryName = $payloadObj['repository']['name'];

_echo("repository name: {$repositoryName}");

//map repository & real project folder in server
$map = [];

$projectFolder = $repositoryName;

//if $repository contains "laravel", remove it
$isLaravelProject = is_numeric(strpos($projectFolder, "laravel"))? true : false;

_echo("laravel project: {$isLaravelProject}");

//rm laravel- from projectFolder name
$projectFolder = str_replace("laravel-", "", $repositoryName);

//deal with special case
if(isset($map[$repositoryName])){
	$projectFolder = $map[$repositoryName];
}

//build full-path
$projectFolder = __DIR__ . "/" . $projectFolder;

_echo("project folder: {$projectFolder}");

if(!is_dir($projectFolder)){
	echo "mkdir {$projectFolder}";
	mkdir($projectFolder);
}

_echo("chdir");

chdir($projectFolder);

_echo(shell_exec("whoami"));

_echo(shell_exec("git stash"));

_echo(shell_exec("git pull origin master"));

_echo( date("Y-m-d H:i:s"));


//deal with NPM project
if($repositoryName == "fabric-table-layout"){
	_echo("fabric-table-layout repository need NPM");
	//www-data added to visudo
	//www-data    ALL=NOPASSWD: /usr/bin/npm
	//this means that www-data can run
	//SUDO NPM INSTALL
	//without prompt sudo password
	//NPM MUST BE RUN BY SUDO
	//update if some change on package.json
	_echo(shell_exec("sudo npm install"));
	//compile file
	_echo(shell_exec("gulp"));
}

//deal with laravel project
if($isLaravelProject){
	_echo(shell_exec("php artisan migrate"));
}

//write to log file
$log = implode("\r\n", $msgs);

$logFile = fopen("github-webhook.log", "w");

fwrite($logFile, $log);

fclose($logFile);



echo "success";
die;