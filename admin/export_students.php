<?php
/**
 * Export Interested Students to CSV
 *
 * Allows admins to export a list of interested students to a CSV file.
 *
 * @package AdminExportStudents
 */

session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Retrieve data from the database
$sql = "SELECT isd.StudentName, isd.Email, p.ProgrammeName FROM InterestedStudents isd INNER JOIN Programmes p ON isd.ProgrammeID = p.ProgrammeID";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="interested_students.csv"');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Add CSV header
    fputcsv($output, array('Name', 'Email', 'Interested Program'));

    // Add data rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    // Close output stream
    fclose($output);
} else {
    echo "No students found.";
}

$conn->close();
?>