<?php
session_start();
include 'includes/database.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

// Fetch all tasks
try {
    $stmt = $pdo->query("SELECT * FROM Tasks");
    $tasks = $stmt->fetchAll();
} catch (Exception $e) {
    die('Error fetching tasks: ' . $e->getMessage());
}

// Add a new task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $task_time = $_POST['task_time'];
    $location = $_POST['location'];
    $people_needed = $_POST['people_needed'];

    $query = "INSERT INTO Tasks (task_name, task_description, task_time, location, people_needed) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute([$task_name, $task_description, $task_time, $location, $people_needed])) {
        header("Location: admin.php"); // Refresh the page to see new task
        exit;
    } else {
        $error = "Failed to add new task.";
    }
}

include 'includes/header.php';
?>

<h2>Admin Dashboard</h2>
<h3>Tasks Overview</h3>
<table border="1">
    <thead>
        <tr>
            <th>Task Name</th>
            <th>Description</th>
            <th>Time</th>
            <th>Location</th>
            <th>People Needed</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?php echo htmlspecialchars($task['task_name']); ?></td>
            <td><?php echo htmlspecialchars($task['task_description']); ?></td>
            <td><?php echo htmlspecialchars($task['task_time']); ?></td>
            <td><?php echo htmlspecialchars($task['location']); ?></td>
            <td><?php echo htmlspecialchars($task['people_needed']); ?></td>
            <td>
                <a href="admin_edit_task.php?task_id=<?php echo $task['task_id']; ?>">Edit</a>
                <a href="admin_delete_task.php?task_id=<?php echo $task['task_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Add New Task</h3>
<form method="post">
    Task Name: <input type="text" name="task_name" required><br>
    Description: <textarea name="task_description" required></textarea><br>
    Time: <input type="datetime-local" name="task_time" required><br>
    Location: <input type="text" name="location" required><br>
    People Needed: <input type="number" name="people_needed" required min="1"><br>
    <input type="submit" name="add_task" value="Add Task">
</form>

<?php include 'includes/footer.php'; ?>
