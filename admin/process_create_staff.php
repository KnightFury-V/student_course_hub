<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffID = $_POST['staff_id'];
    $password = $_POST['password'];

    if (empty($staffID) || empty($password)) {
        $_SESSION['staff_create_error'] = "Staff ID and Password are required.";
        header('Location: create_staff.php');
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if StaffID already exists
    $checkSql = "SELECT StaffID FROM Staff WHERE StaffID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $staffID);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // StaffID exists, update the password
        $updateSql = "UPDATE Staff SET Password = ? WHERE StaffID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $hashedPassword, $staffID);

        if ($updateStmt->execute()) {
            $_SESSION['staff_create_success'] = "Password updated successfully.";
            header('Location: create_staff.php');
            exit;
        } else {
            $_SESSION['staff_create_error'] = "Error updating password: " . $updateStmt->error;
            header('Location: create_staff.php');
            exit;
        }
    } else {
        // StaffID does not exist, create a new user
        $sql = "INSERT INTO Staff (StaffID, Password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $staffID, $hashedPassword);

        if ($stmt->execute()) {
            $_SESSION['staff_create_success'] = "Staff user created successfully.";
            header('Location: create_staff.php');
            exit;
        } else {
            $_SESSION['staff_create_error'] = "Error creating staff user: " . $stmt->error;
            header('Location: create_staff.php');
            exit;
        }
    }
} else {
    header('Location: create_staff.php');
    exit;
}

$conn->close();
?>