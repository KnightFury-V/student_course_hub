<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

// Check if staff is logged in
if (!isset($_SESSION['staff_logged_in']) || $_SESSION['staff_logged_in'] !== true) {
    header('Location: staff_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $staffID = $_SESSION['staff_id'];

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['change_password_error'] = "All fields are required.";
        header('Location: change_password_staff.php');
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        $_SESSION['change_password_error'] = "New passwords do not match.";
        header('Location: change_password_staff.php');
        exit;
    }

    // Verify current password
    $sql = "SELECT Password FROM Staff WHERE StaffID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $staffID);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($currentPassword, $hashedPassword)) {
        $_SESSION['change_password_error'] = "Current password is incorrect.";
        header('Location: change_password_staff.php');
        exit;
    }

    // Update password
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateSql = "UPDATE Staff SET Password = ? WHERE StaffID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("si", $newHashedPassword, $staffID);

    if ($updateStmt->execute()) {
        $_SESSION['change_password_success'] = "Password changed successfully.";
    } else {
        $_SESSION['change_password_error'] = "Error changing password.";
    }

    $updateStmt->close();
    header('Location: change_password_staff.php');
    exit;
}

$conn->close();
?>