<?php
// Tes identifiants GitHub OAuth
$client_id = 'TON_CLIENT_ID';
$client_secret = 'TON_CLIENT_SECRET';
$redirect_uri = 'https://tonpseudo.github.io/tonprojet/callback';

// Récupère le code envoyé par GitHub
$code = $_GET['code'] ?? null;

if (!$code) {
  exit('Pas de code reçu.');
}

// Demande le token d’accès
$response = file_get_contents('https://github.com/login/oauth/access_token?' . http_build_query([
  'client_id' => $client_id,
  'client_secret' => $client_secret,
  'code' => $code,
  'redirect_uri' => $redirect_uri
]), false, stream_context_create([
  'http' => ['header' => 'Accept: application/json']
]));

$data = json_decode($response, true);
$access_token = $data['access_token'] ?? null;

if (!$access_token) {
  exit('Erreur lors de la récupération du token.');
}

// Récupère les infos de l’utilisateur
$user = json_decode(file_get_contents('https://api.github.com/user', false, stream_context_create([
  'http' => [
    'header' => "Authorization: token $access_token\r\nUser-Agent: MonApp"
  ]
])), true);

// Affiche le nom
echo "Bienvenue, " . htmlspecialchars($user['login']);
?>
