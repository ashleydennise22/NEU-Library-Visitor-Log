<?php
date_default_timezone_set('Asia/Manila');
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $dept = $conn->real_escape_string($_POST['dept']);
    $purpose = $conn->real_escape_string($_POST['purpose']);
    $user_type = $conn->real_escape_string($_POST['user_type']);

    // 1. SETUP NG ORAS
    $current_time = date("Y-m-d H:i:s"); 
    $display_time = date('F d, Y | h:i A'); 

    // 2. INSERT SA DATABASE
    $sql = "INSERT INTO visitors (name, email, department, purpose, user_type, login_time) 
            VALUES ('$name', '$email', '$dept', '$purpose', '$user_type', '$current_time')";

    if ($conn->query($sql) === TRUE) {
        // 3. REDIRECT SA WELCOME.PHP
        header("Location: welcome.php?" . 
               "name=" . urlencode($name) . 
               "&dept=" . urlencode($dept) . 
               "&purpose=" . urlencode($purpose) . 
               "&user_type=" . urlencode($user_type) . 
               "&time=" . urlencode($display_time));
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
