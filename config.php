<?php
date_default_timezone_set('Asia/Manila');
require_once __DIR__ . '/vendor/autoload.php';
// I-on ang error reporting para makita ang mga mismatch errors habang nag-te-test
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. MGA CREDENTIALS (Kunin sa Google Cloud Console > Credentials)
// Siguraduhin na walang extra spaces sa loob ng quotes.
$clientID     = '790838646020-qc1ljeu9sv36pd7557t89djl1tqiv8nd.apps.googleusercontent.com';
$clientSecret = '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';

// 2. REDIRECT URI (Dapat EKSAMTONG TUGMA sa Google Console)
// Kung "Invalid URI" pa rin, i-check kung may 'http' vs 'https' o localhost vs 127.0.0.1
$redirectUri  = 'https://neu-library.infinityfree.me/callback.php';

// 3. INITIALIZE GOOGLE CLIENT
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);

// 4. SET SCOPES (Para makuha ang Email at Pangalan ng user)
$client->addScope("email");
$client->addScope("profile");

// Optional: Para sa "Select Account" prompt tuwing mag-lo-log in
$client->setPrompt('select_account');

/**
 * DATABASE CONNECTION (Isama na natin dito para isang tawag na lang sa ibang files)
 */
$db_host = "sql200.infinityfree.com";
$db_user = "if0_41442133";
$db_pass = "y1ymoDF1Ni5bqv";
$db_name = "if0_41442133_neu_library";

// Sinusubukan ang port 3307 (XAMPP default minsan), kung ayaw, gamit ang default 3306
$conn = @new mysqli("$db_host", $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
}

// I-check kung may error sa database connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>