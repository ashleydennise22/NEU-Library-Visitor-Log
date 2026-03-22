<?php
session_start();

// 1. SECURITY CHECK
// Only jcesperanza@neu.edu.ph can perform these actions
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['email'] !== 'jcesperanza@neu.edu.ph') {
    die("Unauthorized access.");
}

// 2. DATABASE CONNECTION
$host = "sql200.infinityfree.com";
$user = "if0_41442133";
$pass = "y1ymoDF1Ni5bqv";
$db   = "if0_41442133_neu_library";

$conn = new mysqli("$host", $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. GET DATA FROM URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$action = $_GET['action'] ?? '';

if ($id > 0 && ($action === 'block' || $action === 'unblock')) {
    // Set status based on action
    $status = ($action === 'block') ? 'blocked' : 'active';
    
    // 4. UPDATE DATABASE
    $stmt = $conn->prepare("UPDATE visitors SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        // Success: Redirect back to admin dashboard
        header("Location: admin.php?msg=success");
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
} else {
    header("Location: admin.php");
}

$conn->close();
?>