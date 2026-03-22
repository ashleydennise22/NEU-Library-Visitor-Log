<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) exit();

$conn = new mysqli("sql200.infinityfree.com", "if0_41442133", "y1ymoDF1Ni5bqv", "if0_41442133_neu_library");

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Library_Visitors_Report_" . date('Y-m-d') . ".xls");

// Table Header
echo "Visitor Name\tInstitutional Email\tDepartment\tPurpose\tUser Type\tLogin Time\n";

$logs = $conn->query("SELECT * FROM visitors ORDER BY login_time DESC");

while($row = $logs->fetch_assoc()){
    // Clean data for excel (tabs to separate columns)
    $name = str_replace("\t", " ", $row['name']);
    $email = str_replace("\t", " ", $row['email']);
    $dept = str_replace("\t", " ", $row['department']);
    $purpose = str_replace("\t", " ", $row['purpose']);
    $type = $row['user_type'];
    $time = $row['login_time'];
    
    echo "$name\t$email\t$dept\t$purpose\t$type\t$time\n";
}
exit();
?>