<?php
/**
 * Withdraw Interest Page
 *
 * Handles student withdrawal of interest in a program.
 *
 * @package WithdrawInterest
 */

session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentEmail = isset($_SESSION['student_email']) ? filter_var($_SESSION['student_email'], FILTER_VALIDATE_EMAIL) : null;
    $programmeID = filter_input(INPUT_POST, 'programme_id', FILTER_VALIDATE_INT);

    if (!$studentEmail || !$programmeID) {
        header('Location: index.php?error=invalid_request');
        exit;
    }

    $sqlWithdraw = "DELETE FROM InterestedStudents WHERE Email = ? AND ProgrammeID = ?";
    $stmtWithdraw = $conn->prepare($sqlWithdraw);
    $stmtWithdraw->bind_param("si", $studentEmail, $programmeID);

    if ($stmtWithdraw->execute()) {
        header('Location: programme_details.php?programme_id=' . $programmeID . '&withdraw_success=1');
        exit;
    } else {
        header('Location: programme_details.php?programme_id=' . $programmeID . '&withdraw_error=1');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>