<?php
// process_final_log.php
date_default_timezone_set('Asia/Manila');
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pagkuha at pag-sanitize ng data mula sa purpose.php
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $dept = $conn->real_escape_string($_POST['dept']);
    $purpose = $conn->real_escape_string($_POST['purpose']);
    $user_type = $conn->real_escape_string($_POST['user_type']);

    // 1. SETUP NG ORAS
    $current_time = date("Y-m-d H:i:s"); // Para sa database (login_time column)
    $display_time = date('F d, Y | h:i A'); // Para sa welcome.php display

    // 2. INSERT SA DATABASE
    // Siguraduhin na 'login_time' ang column name sa visitors table mo
    $sql = "INSERT INTO visitors (name, email, department, purpose, user_type, login_time) 
            VALUES ('$name', '$email', '$dept', '$purpose', '$user_type', '$current_time')";

    if ($conn->query($sql) === TRUE) {
        // 3. REDIRECT SA WELCOME.PHP
        // Ipinapasa ang lahat ng data kasama ang formatted time
        header("Location: welcome.php?" . 
               "name=" . urlencode($name) . 
               "&dept=" . urlencode($dept) . 
               "&purpose=" . urlencode($purpose) . 
               "&user_type=" . urlencode($user_type) . 
               "&time=" . urlencode($display_time));
        exit();
    } else {
        // Error handling kung sakaling hindi pumasok sa database
        echo "Error: " . $conn->error;
    }
}
?>