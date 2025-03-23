<?php
/**
 * Admin Dashboard Page
 *
 * Displays links to manage programs, modules, students, and create staff/admin accounts.
 * Requires admin login.
 *
 * @package AdminDashboard
 */

session_start();
include '../includes/db_connect.php';
include '../includes/functions.php'; // Include functions.php to access isSuperuser

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Check if admin is a superuser
$isSuperuser = isSuperuser($conn, $_SESSION['admin_username']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/stylesadminindex.css">
</head>
<body>
    <h1 class="admin">Welcome to Admin Dashboard</h1>
    <div class="program-grid">
        <ul>
            <li><a href="programs.php">Manage Programs</a></li>
            <li><a href="modules.php">Manage Modules</a></li>
            <li><a href="students.php">View Interested Students</a></li>
            <li><a href="create_staff.php">Create Staff Account</a></li>
            <?php if ($isSuperuser): ?>
                <li><a href="create_admin.php">Create Admin User</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>

<?php $conn->close(); ?>