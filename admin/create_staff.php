<?php
/**
 * Create Staff User Page
 *
 * Allows admins to create staff user accounts.
 *
 * @package AdminCreateStaff
 */

session_start();
session_regenerate_id(true);
include '../includes/db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$error = isset($_SESSION['staff_create_error']) ? $_SESSION['staff_create_error'] : '';
$success = isset($_SESSION['staff_create_success']) ? $_SESSION['staff_create_success'] : '';

unset($_SESSION['staff_create_error']);
unset($_SESSION['staff_create_success']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Staff User</title>
    <link rel="stylesheet" href="../css/stylesadmincreateuser.css">
</head>
<body>
    <div class="admin-create">
        <h1>Create Staff User</h1>

        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <form method="post" action="process_create_staff.php">
            <label for="staff_id">Staff ID:</label>
            <input type="number" name="staff_id" id="staff_id" required><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>

            <input type="submit" value="Create Staff User">
        </form><br>
        <p><a href="index.php">Back to Dashboard</a></p>
    </div>
   

</body>
</html>

<?php $conn->close(); ?>