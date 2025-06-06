<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload do Composer
require_once __DIR__ . '/vendor/autoload.php';

$google_client = new Google_Client();
$google_client->setClientId('1084358701215-25gsqng3f2gppchnhhfhqvs881jk5ahv.apps.googleusercontent.com');
$google_client->setClientSecret('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');
$google_client->setRedirectUri('http://localhost/pap/google-callback.php'); // Certifica-te que tens esta página
$google_client->addScope('email');
$google_client->addScope('profile');
?>
