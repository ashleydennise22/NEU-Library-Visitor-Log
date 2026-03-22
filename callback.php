<?php
// callback.php
require_once __DIR__ . '/config.php';
date_default_timezone_set('Asia/Manila');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        $google_oauth = new \Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $email = $google_account_info->email;
        $name = $google_account_info->name;

        if (!str_ends_with($email, '@neu.edu.ph')) {
            session_unset();
            session_destroy();
            header("Location: index.php?error=Access Denied: Please use your official @neu.edu.ph email.");
            exit();
        }

        $allowed_admins = ['jcesperanza@neu.edu.ph', 'ashleydennise.alberto@neu.edu.ph'];

        if (isset($_SESSION['login_role']) && $_SESSION['login_role'] === 'admin') {
            
            // --- ADMIN LOGIN FLOW ---
            if (in_array($email, $allowed_admins)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                unset($_SESSION['login_role']); 
                header("Location: admin.php");
                exit();
            } else {
                session_unset();
                session_destroy();
                header("Location: admin_login.php?error=Access Denied: Authorized Personnel Only");
                exit();
            }

       } else {            
            $check_email = $conn->real_escape_string($email);
            $check_blocked = $conn->query("SELECT status FROM visitors WHERE email = '$check_email' AND status = 'blocked' LIMIT 1");
            
            if ($check_blocked && $check_blocked->num_rows > 0) {
                session_unset();
                session_destroy();
                header("Location: index.php?error=Access Denied: Your account is restricted.");
                exit();
            }
        
            header("Location: purpose.php?name=" . urlencode($name) . "&email=" . urlencode($email));
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
