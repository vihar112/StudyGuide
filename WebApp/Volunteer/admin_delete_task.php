<?php
session_start();
include 'includes/database.php'; // Ensure this includes your PDO connection setup correctly

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit;
}

// Retrieve the task ID either from POST or GET for initial display
$task_id = isset($_POST['task_id']) ? $_POST['task_id'] : (isset($_GET['task_id']) ? $_GET['task_id'] : null);

if (!$task_id) {
    echo "No task ID provided.";
    exit;
}

// Check if the task exists before trying to delete
$stmt = $pdo->prepare("SELECT * FROM Tasks WHERE task_id = ?");
$stmt->execute([$task_id]);
$task = $stmt->fetch();

if (!$task) {
    echo "Task does not exist with ID: " . htmlspecialchars($task_id);
    exit;
}

// Handle the deletion of the task
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("DELETE FROM Tasks WHERE task_id = ?");
    if (!$stmt->execute([$task_id])) {
        echo "Failed to delete the task. Error: " . implode(", ", $stmt->errorInfo());
        exit; // Stop further execution if there's an error
    } else {
        header('Location: admin.php'); // Redirect after successful deletion
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Task Confirmation</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Delete Task</h1>
    <p>Are you sure you want to delete this task: <?php echo htmlspecialchars($task['task_name']); ?>?</p>
    <form method="post">
        <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task_id); ?>">
        <input type="submit" value="Delete Task">
    </form>
</body>
</html>
