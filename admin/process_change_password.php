<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $adminUsername = $_SESSION['admin_username'];

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['change_password_error'] = "All fields are required.";
        header('Location: change_password.php');
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        $_SESSION['change_password_error'] = "New passwords do not match.";
        header('Location: change_password.php');
        exit;
    }

    // Verify current password
    $sql = "SELECT Password FROM Admins WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $adminUsername);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($currentPassword, $hashedPassword)) {
        $_SESSION['change_password_error'] = "Current password is incorrect.";
        header('Location: change_password.php');
        exit;
    }

    // Update password
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateSql = "UPDATE Admins SET Password = ? WHERE Username = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ss", $newHashedPassword, $adminUsername);

    if ($updateStmt->execute()) {
        $_SESSION['change_password_success'] = "Password changed successfully.";
    } else {
        $_SESSION['change_password_error'] = "Error changing password.";
    }

    $updateStmt->close();
    header('Location: change_password.php');
    exit;
}

$conn->close();
?>