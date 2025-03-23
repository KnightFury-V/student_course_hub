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
    <a id="top"></a>
    <title>Manage Modules</title>
    <link rel="stylesheet" href="../css/stylesadminmodules_programs.css">
</head>
<body>
   
    <h1>Manage Modules</h1>
    <span><a href="add_module.php" class="button">Add Module</a>
    <a href="#bottom" class="button">Go to Bottom</a>
     <a href="index.php" class="button">Back to Dashboard</a>
    
    </span> <br>

    <div class="program-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="program-item">
                    <img src="../images/modules/<?= htmlspecialchars($row['Image']) ?>" alt="<?= htmlspecialchars($row['ModuleName']) ?>">
                    <h2><?= htmlspecialchars($row['ModuleName']) ?></h2>
                    <p>Leader: <?= htmlspecialchars(getStaffName($conn, $row['ModuleLeaderID']) ?: "Leader Not Found") ?></p>
                    <p><?= htmlspecialchars(substr($row['Description'], 0, 100)) ?>...</p>
                    <p><a href="edit_module.php?id=<?= htmlspecialchars($row['ModuleID']) ?>">Edit</a> | <a href="delete_module.php?id=<?= htmlspecialchars($row['ModuleID']) ?>" onclick="return confirm('Are you sure?')">Delete</a></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No modules found.</p>
        <?php endif; ?>
    </div>

    <a id="bottom"></a>
    <a href="#top" class="button">Go to Top</a>
</body>
</html>

<?php $conn->close(); ?>