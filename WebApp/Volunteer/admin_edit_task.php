<?php
session_start();
include 'includes/database.php'; // For database connection
include 'includes/header.php'; // For including header contents

// Redirect if not logged in or not an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit;
}

// Process POST request when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $task_id = $_POST['task_id'];
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $task_time = $_POST['task_time'];
    $location = $_POST['location'];
    $people_needed = $_POST['people_needed'];

    // Prepare SQL statement to update task details
    $stmt = $pdo->prepare("UPDATE Tasks SET task_name = ?, task_description = ?, task_time = ?, location = ?, people_needed = ? WHERE task_id = ?");
    if (!$stmt->execute([$task_name, $task_description, $task_time, $location, (int)$people_needed, $task_id])) {
        die('Update failed: ' . $stmt->errorInfo()[2]); // Set up for proper error handling
    }

    header('Location: admin.php'); // Once login is sucessfull it will redirect after successful update
    exit();
}

// Fetch task details to display in the form
$task_id = isset($_GET['task_id']) ? (int)$_GET['task_id'] : 0; // Basic validation for task_ID
if ($task_id <= 0) {
    die('Invalid Task ID.'); // Error handling for invalid task_id
}

$stmt = $pdo->prepare("SELECT * FROM Tasks WHERE task_id = ?");
$stmt->execute([$task_id]);
$task = $stmt->fetch();

if (!$task) {
    die('Task not found.'); // Handle case where no task is found
}
?>

<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Edit Task Details</h1>
    <form action="admin_edit_task.php" method="post">
        <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['task_id']); ?>">
        Task Name: <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required><br>
        Description: <textarea name="task_description" required><?php echo htmlspecialchars($task['task_description']); ?></textarea><br>
        Time: <input type="datetime-local" name="task_time" value="<?php echo date('Y-m-d\TH:i', strtotime($task['task_time'])); ?>" required><br>
        Location: <input type="text" name="location" value="<?php echo htmlspecialchars($task['location']); ?>" required><br>
        People Needed: <input type="number" name="people_needed" value="<?php echo htmlspecialchars($task['people_needed']); ?>" required min="1"><br>
        <input type="submit" name="update" value="Update Task">
    </form>
</body>
</html>
<?php include 'includes/footer.php'; ?>
