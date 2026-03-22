<?php
date_default_timezone_set('Asia/Manila');
require_once __DIR__ . '/vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$clientID     = '790838646020-qc1ljeu9sv36pd7557t89djl1tqiv8nd.apps.googleusercontent.com';
$clientSecret = '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';

$redirectUri  = 'https://neu-library.infinityfree.me/callback.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);

$client->addScope("email");
$client->addScope("profile");

$client->setPrompt('select_account');

/**
 * DATABASE CONNECTION 
 */
$db_host = "sql200.infinityfree.com";
$db_user = "if0_41442133";
$db_pass = "y1ymoDF1Ni5bqv";
$db_name = "if0_41442133_neu_library";

$conn = @new mysqli("$db_host", $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
}

// I-check kung may error sa database connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
