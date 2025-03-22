<?php
/**
 * Admin Modules Page
 *
 * Displays a list of modules with options to add, edit, and delete.
 * Requires admin login.
 *
 * @package AdminModules
 */

session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Fetch modules from the database
$sql = "SELECT ModuleID, ModuleName, Description, Image, ModuleLeaderID FROM Modules";
$result = $conn->query($sql);

if (!$result) {
    die("Database error: " . $conn->error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Modules</title>
    <link rel="stylesheet" href="../css/stylesadminmodules.css">
</head>
<body>
    <h1>Manage Modules</h1>
    <a href="add_module.php">Add Module</a>
    <a href="index.php">Back to Dashboard</a>
    <div class="program-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="program-item">
                    <img src="../images/modules/<?php echo htmlspecialchars($row['Image']); ?>" alt="<?php echo htmlspecialchars($row['ModuleName']); ?>">
                    <h2><?php echo htmlspecialchars($row['ModuleName']); ?></h2>
                    <p>Leader: <?php echo htmlspecialchars(getStaffName($conn, $row['ModuleLeaderID']) ?: "Leader Not Found"); ?></p>
                    <p><?php echo htmlspecialchars(substr($row['Description'], 0, 100)); ?>...</p>
                    <a href="edit_module.php?id=<?php echo htmlspecialchars($row['ModuleID']); ?>">Edit</a> |
                    <a href="delete_module.php?id=<?php echo htmlspecialchars($row['ModuleID']); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No modules found.</p>
        <?php endif; ?>
    </div>
   
</body>
</html>

<?php $conn->close(); ?>