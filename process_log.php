<?php
// process_log.php
require_once 'config.php';
date_default_timezone_set('Asia/Manila');

// Database Connection
$conn = @new mysqli("sql200.infinityfree.com", "if0_41442133", "y1ymoDF1Ni5bqv", "if0_41442133_neu_library");
if ($conn->connect_error) { 
    $conn = new mysqli("sql200.infinityfree.com", "if0_41442133", "y1ymoDF1Ni5bqv", "if0_41442133_neu_library"); 
}

$name = $_REQUEST['name'] ?? '';
$email = trim($_REQUEST['email'] ?? '');
$purpose = $_REQUEST['purpose'] ?? 'General Visit';
$department = trim($_REQUEST['department'] ?? '');
$user_type = $_REQUEST['user_type'] ?? 'STUDENT'; 

if (!$name || !$email) {
    header("Location: index.php?error=Missing Information");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // CHECK KUNG ENDS WITH @neu.edu.ph
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@neu.edu.ph')) {
        header("Location: index.php?error=Only @neu.edu.ph emails are allowed.");
        exit();
    }
}

$name = $conn->real_escape_string($name);
$email = $conn->real_escape_string($email);
$purpose = $conn->real_escape_string($purpose);
$department = $conn->real_escape_string($department);
$user_type = $conn->real_escape_string(strtoupper($user_type));

// 1. BLOCK CHECK
$check_blocked = $conn->query("SELECT status FROM visitors WHERE email = '$email' AND status = 'blocked' LIMIT 1");
if ($check_blocked && $check_blocked->num_rows > 0) {
    header("Location: index.php?error=Your account is restricted. Please contact the librarian.");
    exit();
}

// --- ACCURATE TIME SETUP ---
$current_time = date("Y-m-d H:i:s"); // Para sa database (YYYY-MM-DD)
$display_time = date('F d, Y | h:i A'); // Para sa screen (e.g., March 22, 2026 | 06:09 PM)

// 2. INSERT LOG
$sql = "INSERT INTO visitors (name, email, purpose, department, user_type, login_time) 
        VALUES ('$name', '$email', '$purpose', '$department', '$user_type', '$current_time')";

if ($conn->query($sql)) {
    // 3. REDIRECT TO WELCOME.PHP
    header("Location: welcome.php?name=" . urlencode($name) . 
           "&dept=" . urlencode($department) . 
           "&purpose=" . urlencode($purpose) . 
           "&user_type=" . urlencode($user_type) . 
           "&time=" . urlencode($display_time));
    exit();
} else {
    // Ipakita ang error kung meron man para madaling i-debug
    die("Error: " . $conn->error);
}
exit();
?>
