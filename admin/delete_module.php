<?php
session_start();
session_regenerate_id(true); // Prevent session fixation attacks

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include '../includes/db_connect.php';

// Get and sanitize module ID
$moduleID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$confirm = filter_input(INPUT_GET, 'confirm', FILTER_VALIDATE_INT);

if (!$moduleID) {
    header('Location: modules.php?error=invalid_id'); // Redirect if ID is invalid
    exit;
}

// If confirmed, delete the module
if ($confirm === 1) {
    $sql = "DELETE FROM Modules WHERE ModuleID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $moduleID);
        if ($stmt->execute()) {
            header('Location: modules.php?message=deleted');
            exit;
        } else {
            header('Location: modules.php?error=delete_failed');
            exit;
        }
        $stmt->close();
    } else {
        header('Location: modules.php?error=stmt_failed');
        exit;
    }
}

// Show confirmation only if not confirmed yet
if ($confirm !== 1) {
    echo "<script>
        let confirmDelete = confirm;
        if (confirmDelete) {
            window.location.href = 'delete_module.php?id=" . htmlspecialchars($moduleID, ENT_QUOTES, 'UTF-8') . "&confirm=1';
        } else {
            window.location.href = 'modules.php';
        }
    </script>";
}

$conn->close();
?>
