<?php
$settings = file_get_contents("data.json");
$settings = json_decode($settings);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

$sender = $settings->agent_id;
$app_code = $settings->app_id;
$secret = $settings->secret;
$base_url = $settings->url;

$room_id = $data->payload->room->id;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "$base_url",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
	"sender_email": "'.$sender.'", 
	"message": "Halo ges",
	"type": "text",
	"room_id": "'.$room_id.'"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'QISCUS_SDK_SECRET: '.$secret
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
} else {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bot</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="col-md-4">
        <h2>Bot Setting</h2>
  <form action="/action.php" method="POST">
    <div class="form-group">
      <label>Agent ID</label>
      <input type="text" class="form-control" name="agent_id" value="<?php echo $settings->agent_id; ?>">
    </div>
    <div class="form-group">
      <label>App ID</label>
      <input type="text" class="form-control" name="app_id" value="<?php echo $settings->app_id; ?>">
    </div>
    <div class="form-group">
      <label>Secret</label>
      <input type="text" class="form-control" name="secret" value="<?php echo $settings->secret; ?>">
    </div>
    <div class="form-group">
      <label>Url</label>
      <input type="text" class="form-control" name="url" value="<?php echo $settings->url; ?>">
    </div>
    
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
  </div>
</div>

</body>
</html>
    
	<?php
}

?>
