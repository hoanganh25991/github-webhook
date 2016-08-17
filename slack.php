<?php
// //send to slack
$slackUrl = "https://hooks.slack.com/services/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";

$icon_url = "http://128.199.237.219/slack-icon.png";

// // $username = "Auto-deploy ..... (¯`v´¯)♥
// // .......•.¸.•´
// // ....¸.•´
// // ... (
// // ☻/
// // /▌♥♥
// // / \ ♥♥";
$username = "Auto-deploy";

$params = array(
    "text" => "vai the",
    "username" => $username,
    "icon_url" => $icon_url
  );    
$params_string = "payload=" . json_encode($params);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $slackUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //don't verify SSL server
$result = curl_exec($ch);
curl_close($ch);