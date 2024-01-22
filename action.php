<?php
$agent = $_POST["agent_id"];
$app_id = $_POST["app_id"];
$secret = $_POST["secret"];
$url = $_POST["url"];

if(isset($agent) && isset($app_id) && isset($secret) && isset($url)) {
    $data = [
        "agent_id" => $agent,
        "app_id" => $app_id,
        "secret" => $secret,
        "url" => $url
    ];
    
    $dataString = json_encode($data);
    file_put_contents("data.json", $dataString);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    
}

?>