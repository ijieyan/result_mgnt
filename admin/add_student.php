<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO students (student_id, name, class, password) VALUES (:student_id, :name, :class, :password)");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
        $message = "Student added successfully.";
    } else {
        $error = "Error adding student.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/styles.css">
<title>Add Student</title>
</head>
<body>
    <h1>Add Student</h1>
    <form method="POST">
        <label>Student ID:</label>
        <input type="text" name="student_id" required>
        <br>
        <label>Name:</label>
        <input type="text" name="name" required>
        <br>
        <label>Class:</label>
        <input type="text" name="class" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Add Student</button>
    </form>
    <?php 
    if (isset($message)) echo "<p style='color: green;'>$message</p>";
    if (isset($error)) echo "<p style='color: red;'>$error</p>";
    ?>
</body>
</html>
