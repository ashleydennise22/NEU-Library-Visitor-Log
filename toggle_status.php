<?php
// toggle_status.php
require_once 'config.php';

// Security: Check kung admin ay naka-login
if (!isset($_SESSION['admin_logged_in'])) {
    exit("Unauthorized");
}

if (isset($_GET['id']) && isset($_GET['current_status'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $current_status = $_GET['current_status'];
    
    $new_status = ($current_status === 'blocked') ? 'active' : 'blocked';
    
    $sql = "UPDATE visitors SET status = '$new_status' WHERE id = '$id'";
    
    if ($conn->query($sql)) {
        header("Location: admin.php?msg=status_updated");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
