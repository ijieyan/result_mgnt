<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/styles.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome to Admin Dashboard</h1>
    <nav>
        <a href="add_student.php">Add Student</a>
        <a href="add_course.php">Add Course</a>
        <a href="add_result.php">Add Result</a>
        <a href="view_results.php">View Results</a>
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>
