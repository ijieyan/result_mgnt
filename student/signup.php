<?php
session_start();
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $student_id = $_POST['student_id']; // Adding student ID field

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if the username already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $error = "Username already exists.";
        } else {
            // Insert new user into the database with Student ID
            $stmt = $conn->prepare("INSERT INTO users (username, password, student_id) VALUES (:username, :password, :student_id)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':student_id', $student_id); // Bind student ID
            if ($stmt->execute()) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $conn->lastInsertId(); // Store the user ID
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Error creating user.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../student/styles.css">
    <title>User Signup</title>
</head>
<body>
    <form method="POST">
        <h1>Create Account</h1>
        
        <label>Student ID:</label>
        <input type="text" name="student_id" required>
        <br>

        <label>Username:</label>
        <input type="text" name="username" required>
        <br>
        
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        <br>

        <button type="submit">Sign Up</button>

        <!-- Back Button -->
        <a href="../index.php" class="back-button">Back to Home</a>

    </form>

    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

</body>
</html>
