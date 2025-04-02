<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit;
}

// Example for admin pages
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php'); // Redirect to a different page if not an admin
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $task_time = $_POST['task_time'];
    $location = $_POST['location'];
    $people_needed = $_POST['people_needed'];

    $stmt = $pdo->prepare("INSERT INTO Tasks (task_name, task_description, task_time, location, people_needed) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$task_name, $task_description, $task_time, $location, (int)$people_needed]);
    header('Location: admin.php');
    exit();
}

include 'includes/header.php';
?>

<form method="post">
    Task Name: <input type="text" name="task_name" required><br>
    Description: <textarea name="task_description" required></textarea><br>
    Time: <input type="datetime-local" name="task_time" required><br>
    Location: <input type="text" name="location" required><br>
    People Needed: <input type="number" name="people_needed" required min="1"><br>
    <input type="submit" value="Create Task">
</form>

<?php include 'includes/footer.php'; ?>
