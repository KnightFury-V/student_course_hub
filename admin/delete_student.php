<?php
/**
 * Delete Student Interest Page
 *
 * Allows admins to delete student interest records.
 *
 * @package AdminDeleteStudent
 */

session_start();
include '../includes/db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Get interest ID from URL
$interestID = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : 0;

if (!$interestID) {
    header('Location: students.php?error=invalid_id');
    exit;
}

// Delete student interest record
$sql = "DELETE FROM InterestedStudents WHERE InterestID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $interestID);

if ($stmt->execute()) {
    header('Location: students.php?success=deleted');
    exit;
} else {
    header('Location: students.php?error=deletion_failed');
    exit;
}

$conn->close();
?>