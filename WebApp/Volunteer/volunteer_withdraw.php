<?php
session_start();
include 'includes/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

echo "<pre>POST Data:\n";
print_r($_POST);
echo "</pre>";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup_id'])) {
    $signup_id = $_POST['signup_id'];

    $stmt = $pdo->prepare("DELETE FROM Signups WHERE signup_id = ?");
    $stmt->execute([$signup_id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = "Successfully withdrawn from the task.";
        header('Location: volunteer.php');
        exit();
    } else {
        echo "No signup found to withdraw."; // Specific error if no rows are affected
    }
} else {
    echo "Invalid request or missing signup ID.";
}
?>

<p>If you navigated to this page by mistake, please return to the <a href="volunteer.php">volunteer page</a>.</p>
