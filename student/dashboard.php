<?php
session_start();
include '../config/database.php';

// Check if the user is logged in and has the role 'user'
if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

// Fetch student details (optional: you can modify to show student's details)
$userId = $_SESSION['user_id']; // Assuming you store the user ID in session
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Student Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <p>You are logged in as a student.</p>

        <!-- Student Dashboard Links -->
        <nav>
            <a href="view_results.php">View My Results</a>
            <a href="update_profile.php">Update Profile</a>
            <a href="logout.php">Logout</a>
        </nav>

        <!-- Optionally, add any personalized student content below -->
        <div class="student-info">
            <h2>Your Details</h2>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Account Type:</strong> Student</p>
        </div>
    </div>
</body>
</html>
