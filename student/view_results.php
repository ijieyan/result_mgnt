<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['student_logged_in'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

$stmt = $conn->prepare("SELECT courses.course_name, results.marks FROM results 
                        JOIN courses ON results.course_code = courses.course_code 
                        WHERE results.student_id = :student_id");
$stmt->bindParam(':student_id', $student_id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../student/styles.css">
    <title>View Results</title>
</head>
<body>
    <h1>Your Results</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Marks</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result): ?>
                <tr>
                    <td><?= htmlspecialchars($result['course_name']) ?></td>
                    <td><?= htmlspecialchars($result['marks']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
