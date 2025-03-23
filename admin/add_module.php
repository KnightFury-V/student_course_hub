<?php
/**
 * Add Module Page
 *
 * Allows admins to add new modules.
 *
 * @package AdminAddModule
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../includes/db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Corrected variable names to match form input names
    $moduleName = $_POST['module_name'];
    $description = $_POST['description'];
    $moduleLeaderID = $_POST['module_leader_id'];
    $image = $_POST['image'];

    // Validate inputs
    if (!$moduleName || !$description || !$image || !$moduleLeaderID) {
        $error = "Please fill in all fields.";
    } else {

        // Verify ModuleLeaderID exists in Staff table
        $staffCheckSql = "SELECT StaffID FROM Staff WHERE StaffID = ?";
        $staffCheckStmt = $conn->prepare($staffCheckSql);
        $staffCheckStmt->bind_param("i", $moduleLeaderID);
        $staffCheckStmt->execute();
        $staffCheckResult = $staffCheckStmt->get_result();

        if ($staffCheckResult->num_rows == 0) {
            $error = "Invalid Module Leader ID. Please select a valid Staff ID.";
        } else {
            // ModuleLeaderID is valid, proceed with module insertion
            $result = $conn->query("SELECT MAX(ModuleID) as maxID from Modules");
            $row = $result->fetch_assoc();
            $moduleID = $row['maxID'] + 1;

            $sql = "INSERT INTO Modules (ModuleID, ModuleName, Description, Image, ModuleLeaderID) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die('Error preparing statement: ' . $conn->error);
            }

            $stmt->bind_param("isssi", $moduleID, $moduleName, $description, $image, $moduleLeaderID);

            if ($stmt->execute()) {
                $success = 'Module added successfully.';
                // Prompt and redirect using JavaScript
                echo "<script>
                    alert('Module added successfully!');
                    window.location.href = 'modules.php?success=1';
                </script>";
                // No immediate PHP redirect
            } else {
                $error = 'Error adding module: ' . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Module</title>
    <link rel="stylesheet" href="../css/stylesadminedit_modules.css">
</head>
<body>
    <h1>Add Module</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <div class="add-form">
    <form method="post">
        <label for="module_name">Module Name:</label>
        <input type="text" name="module_name" id="module_name" required><br><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br><br>
        <label for="image">Image Filename:</label>
        <input type="text" name="image" id="image" required><br><br>
        <label for="module_leader_id">Module Leader ID:</label>
        <input type="number" name="module_leader_id" id="module_leader_id" required><br><br>
        <input type="submit" value="Add Module">
    </form>
    </div>
    <p><a href="modules.php">Back to Modules</a></p>
</body>
</html>

<?php $conn->close(); ?>