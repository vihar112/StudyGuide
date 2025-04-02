<?php
session_start();
include 'includes/database.php';
include 'includes/header.php';

$message = ''; // To display messages to the user. Currently set to null, it will be displaced based on condition.

// Check if user is signing up, modifying, or deleting their task signup
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['sign_up'])) {
        $username = trim($_POST['username']) ?: 'guest'; // Default to 'guest' if no username provided
        $task_id = $_POST['task_id'];

        // Check if the user already exists
        $stmt = $pdo->prepare("SELECT user_id FROM Users WHERE username = ?");
        $stmt->execute([$username]);
        $existingUser = $stmt->fetch();

        if (!$existingUser) {
            // Create a new user if not found
            if (!empty($_POST['password'])) {
                // Register user with a password
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Securely hash password
                $stmt = $pdo->prepare("INSERT INTO Users (username, password, is_admin, temporary) VALUES (?, ?, FALSE, FALSE)");
                $stmt->execute([$username, $password]);
            } else {
                // Register a guest user
                $stmt = $pdo->prepare("INSERT INTO Users (username, temporary) VALUES (?, TRUE)");
                $stmt->execute([$username]);
            }
            $user_id = $pdo->lastInsertId();
        } else {
            // Use existing user_id
            $user_id = $existingUser['user_id'];
        }

        // Sign the user up for the selected task
        $stmt = $pdo->prepare("INSERT INTO Signups (user_id, task_id) VALUES (?, ?)");
        if ($stmt->execute([$user_id, $task_id])) {
            $message = 'Signup successful!';
        } else {
            $message = 'Failed to sign up for the task.';
        }
    } elseif (isset($_POST['modify'])) {
        // Modify an existing signup
        $signup_id = $_POST['signup_id'];
        $new_task_id = $_POST['new_task_id'];
        $stmt = $pdo->prepare("UPDATE Signups SET task_id = ? WHERE signup_id = ?");
        if ($stmt->execute([$new_task_id, $signup_id])) {
            $message = 'Signup updated successfully!';
        } else {
            $message = 'Failed to update signup.';
        }
    } elseif (isset($_POST['delete'])) {
        // Delete an existing signup
        $signup_id = $_POST['signup_id'];
        $stmt = $pdo->prepare("DELETE FROM Signups WHERE signup_id = ?");
        if ($stmt->execute([$signup_id])) {
            $message = 'Signup deleted successfully!';
        } else {
            $message = 'Failed to delete signup.';
        }
    }
}

// Fetch tasks to display in the form dropdown
$tasks = $pdo->query("SELECT task_id, task_name FROM Tasks")->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>Volunteer Signup</h1>
<p><?php echo $message; ?></p>
<form action="volunteer_signup.php" method="post">
    Username: <input type="text" name="username" placeholder="Enter username or leave blank for guest"><br>
    Password (optional): <input type="password" name="password" placeholder="Password for new users"><br>
    Task: <select name="task_id">
        <?php foreach ($tasks as $task) {
            echo "<option value=\"{$task['task_id']}\">{$task['task_name']}</option>";
        } ?>
    </select><br>
    <input type="submit" name="sign_up" value="Sign Up">
</form>

<?php include 'includes/footer.php'; ?>
