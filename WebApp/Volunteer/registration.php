<?php
session_start();
include 'includes/database.php';

// Handle user registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Securely hash the password

    // Check if the username already exists
    $checkStmt = $pdo->prepare("SELECT user_id FROM Users WHERE username = ?");
    $checkStmt->execute([$username]);
    if ($checkStmt->fetch()) {
        $error_message = "Username already exists. Please choose another one.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO Users (username, password, is_admin) VALUES (?, ?, FALSE)");
        if ($stmt->execute([$username, $password])) {
            echo "<p>User registered successfully!</p>";
        } else {
            $error_message = "Registration failed. Please try again.";
        }
    }
}

include 'includes/header.php';
?>

<form method="post" action="registration.php">
    <h2>Register</h2>
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" name="register" value="Register">
    <?php if (!empty($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
</form>

<?php include 'includes/footer.php'; ?>
