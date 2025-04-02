<?php
session_start();
include 'includes/database.php';

$error_message = ""; // Initialize error message

// Process login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];  // Received from login form

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        header("Location: " . ($user['is_admin'] ? 'admin.php' : 'volunteer.php'));
        exit;
    } else {
        $error_message = "Invalid username or password";
    }
}

// Include the HTML header
include 'includes/header.php';
?>
<html>
<body>

<form method="post" action="login.php">
    <h2>Login</h2>
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" name="login" value="Login">
    <?php if (!empty($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
</form>
</body>
</html>

<?php include 'includes/footer.php'; ?>
