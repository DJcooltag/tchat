<?php
$client_id = 'TON_CLIENT_ID';
$client_secret = 'TON_CLIENT_SECRET';
$redirect_uri = 'TON_REDIRECT_URI';

$code = $_GET['code'];

$token_url = "https://discord.com/api/oauth2/token";
$data = [
  'client_id' => $client_id,
  'client_secret' => $client_secret,
  'grant_type' => 'authorization_code',
  'code' => $code,
  'redirect_uri' => $redirect_uri,
  'scope' => 'identify'
];

$options = [
  'http' => [
    'method' => 'POST',
    'header' => 'Content-Type: application/x-www-form-urlencoded',
    'content' => http_build_query($data)
  ]
];

$response = file_get_contents($token_url, false, stream_context_create($options));
$token = json_decode($response, true)['access_token'];

$user_data = file_get_contents("https://discord.com/api/users/@me", false, stream_context_create([
  'http' => [
    'header' => "Authorization: Bearer $token"
  ]
]));

$user = json_decode($user_data, true);
echo "Bienvenue, " . $user['username'];
?>
