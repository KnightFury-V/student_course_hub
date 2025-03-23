<?php
/**
 * Register Interest Page
 *
 * Handles student registration of interest in a program.
 *
 * @package RegisterInterest
 */

include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programID = filter_input(INPUT_POST, 'program_id', FILTER_VALIDATE_INT);
    $studentName = filter_input(INPUT_POST, 'student_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$programID || !$studentName || !$email) {
        echo "Invalid input data.";
        exit;
    }

    $sql = "INSERT INTO InterestedStudents (ProgrammeID, StudentName, Email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $programID, $studentName, $email);

    if ($stmt->execute()) {
        echo "Interest registered successfully!";
    } else {
        echo "Error registering interest.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>