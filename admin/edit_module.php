<?php
/**
 * Edit Module Page
 *
 * Allows admins to edit existing module details.
 *
 * @package AdminEditModule
 */

session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

// Get module ID from URL
$moduleID = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : 0;

if (!$moduleID) {
    echo "Invalid module ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $moduleName = filter_input(INPUT_POST, 'module_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $moduleLeaderID = filter_input(INPUT_POST, 'module_leader_id', FILTER_VALIDATE_INT);

    // Validate inputs
    if (!$moduleName || !$description || !$image || !$moduleLeaderID) {
        $error = "Please fill in all fields.";
    } else {
        // Update module in database
        $sql = "UPDATE Modules SET ModuleName = ?, Description = ?, Image = ?, ModuleLeaderID = ? WHERE ModuleID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $moduleName, $description, $image, $moduleLeaderID, $moduleID);

        if ($stmt->execute()) {
            $success = 'Module updated successfully.';
        } else {
            $error = 'Error updating module.';
        }
    }
}

// Fetch module details
$sql = "SELECT ModuleName, Description, Image, ModuleLeaderID FROM Modules WHERE ModuleID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $moduleID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $module = $result->fetch_assoc();
} else {
    echo "Module not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Module</title>
    <link rel="stylesheet" href="../css/stylesadminedit_modules.css">
</head>
<body>
    <h1>Edit Module</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <div class="add-form">
    <form method="post">
        <label for="module_name">Module Name:</label>
        <input type="text" name="module_name" id="module_name" value="<?php echo htmlspecialchars($module['ModuleName']); ?>" required><br><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo htmlspecialchars($module['Description']); ?></textarea><br><br>
        <label for="image">Image Filename:</label>
        <input type="text" name="image" id="image" value="<?php echo htmlspecialchars($module['Image']); ?>" required><br><br>
        <label for="module_leader_id">Module Leader ID:</label>
        <input type="number" name="module_leader_id" id="module_leader_id" value="<?php echo htmlspecialchars($module['ModuleLeaderID']); ?>" required><br><br>
        <input type="submit" value="Update Module">
    </form>
    </div>
    <p><a href="modules.php">Back to Modules</a></p>
</body>
</html>

<?php $conn->close(); ?>