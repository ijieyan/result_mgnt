<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $course_code = $_POST['course_code'];
    $marks = $_POST['marks'];

    $stmt = $conn->prepare("INSERT INTO results (student_id, course_code, marks) VALUES (:student_id, :course_code, :marks)");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':course_code', $course_code);
    $stmt->bindParam(':marks', $marks);

    if ($stmt->execute()) {
        $message = "Result added successfully.";
    } else {
        $error = "Error adding result.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/styles.css">
    <title>Add Result</title>
</head>
<body>
    <h1>Add Result</h1>
    <form method="POST">
        <label>Student ID:</label>
        <input type="text" name="student_id" required>
        <br>
        <label>Course Code:</label>
        <input type="text" name="course_code" required>
        <br>
        <label>Marks:</label>
        <input type="number" name="marks" required>
        <br>
        <button type="submit">Add Result</button>
    </form>
    <?php 
    if (isset($message)) echo "<p style='color: green;'>$message</p>";
    if (isset($error)) echo "<p style='color: red;'>$error</p>";
    ?>
</body>
</html>
