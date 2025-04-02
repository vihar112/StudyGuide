<?php
session_start();
include 'includes/database.php';
include 'includes/header.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch all available tasks
$stmt = $pdo->query("SELECT * FROM Tasks");
$tasks = $stmt->fetchAll();

// Fetch user's signups
$stmt = $pdo->prepare("SELECT Tasks.*, Signups.signup_id FROM Tasks JOIN Signups ON Tasks.task_id = Signups.task_id WHERE Signups.user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$signups = $stmt->fetchAll();
?>

<h2>Welcome to the Volunteer Dashboard</h2>

<h3>Available Tasks</h3>
<table>
    <tr>
        <th>Task Name</th>
        <th>Description</th>
        <th>Time</th>
        <th>Location</th>
        <th>People Needed</th>
        <th>Sign Up</th>
    </tr>
    <?php foreach ($tasks as $task): ?>
    <tr>
        <td><?php echo htmlspecialchars($task['task_name']); ?></td>
        <td><?php echo htmlspecialchars($task['task_description']); ?></td>
        <td><?php echo htmlspecialchars($task['task_time']); ?></td>
        <td><?php echo htmlspecialchars($task['location']); ?></td>
        <td><?php echo htmlspecialchars($task['people_needed']); ?></td>
        <td>
            <form action="volunteer_signup.php" method="post">
                <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">
                <input type="submit" value="Sign Up">
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Your Signed Up Tasks</h3>
<table>
    <tr>
        <th>Task Name</th>
        <th>Description</th>
        <th>Time</th>
        <th>Location</th>
        <th>Withdraw</th>
    </tr>
    <?php foreach ($signups as $task): ?>
    <tr>
        <td><?php echo htmlspecialchars($task['task_name']); ?></td>
        <td><?php echo htmlspecialchars($task['task_description']); ?></td>
        <td><?php echo htmlspecialchars($task['task_time']); ?></td>
        <td><?php echo htmlspecialchars($task['location']); ?></td>
        <td>
            <form action="volunteer_withdraw.php" method="post">
                <input type="hidden" name="signup_id" value="<?php echo $task['signup_id']; ?>">
                <input type="submit" value="Withdraw">
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'includes/footer.php'; ?>
