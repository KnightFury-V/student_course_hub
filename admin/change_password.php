<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$error = isset($_SESSION['change_password_error']) ? $_SESSION['change_password_error'] : '';
$success = isset($_SESSION['change_password_success']) ? $_SESSION['change_password_success'] : '';

unset($_SESSION['change_password_error']);
unset($_SESSION['change_password_success']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/stylesadmincreateuser.css">
</head>
<body>
    <h1>Change Password</h1>
    <div class="admin-create">
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <form method="post" action="process_change_password.php">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" id="current_password" required><br><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required><br><br>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br><br>

        <input type="submit" value="Change Password">
    </form><br>
    <p><a href="index.php">Back to Dashboard</a></p>
    </div>
</body>
</html>

<?php $conn->close(); ?>