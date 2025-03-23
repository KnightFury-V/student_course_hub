<?php
/**
 * Delete Program Page
 *
 * Allows admins to delete program records with confirmation.
 *
 * @package AdminDeleteProgram
 */

session_start();
session_regenerate_id(true); // Prevent session fixation attacks

include '../includes/db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Get program ID from URL and sanitize it
$programID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$confirm = filter_input(INPUT_GET, 'confirm', FILTER_VALIDATE_INT);

if (!$programID) {
    header('Location: programs.php'); // Redirect if ID is invalid
    exit;
}

if ($confirm === 1) {
    // Proceed with deletion
    $sql = "DELETE FROM Programmes WHERE ProgrammeID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $programID);
        if ($stmt->execute()) {
            header('Location: programs.php?message=deleted');
            exit;
        } else {
            header('Location: programs.php?error=delete_failed');
            exit;
        }
    } else {
        header('Location: programs.php?error=stmt_failed');
        exit;
    }
} else {
    // Display confirmation prompt
    echo "<script>
        if (confirm('Are you sure you want to delete this program?')) {
            window.location.href = 'delete_program.php?id=" . htmlspecialchars($programID, ENT_QUOTES, 'UTF-8') . "&confirm=1';
        } else {
            window.location.href = 'programs.php';
        }
    </script>";
}

$conn->close();
?>
