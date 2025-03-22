<?php
/**
 * View Interested Students Page
 *
 * Displays a list of students who have registered interest in programs.
 *
 * @package AdminStudents
 */

session_start();
include '../includes/db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Fetch interested students from the database
$sql = "SELECT isd.InterestID, isd.StudentName, isd.Email, p.ProgrammeName FROM InterestedStudents isd INNER JOIN Programmes p ON isd.ProgrammeID = p.ProgrammeID";
$result = $conn->query($sql);

$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Interested Students</title>
    <link rel="stylesheet" href="../css/stylesadminstudents.css">
</head>
<body>
   <h1>Interested Students</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
   

    <a href="export_students.php" class="admin-button">Export Students</a>

    <table>
        
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Interested Program</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['StudentName']); ?></td>
                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                        <td><?php echo htmlspecialchars($row['ProgrammeName']); ?></td>
                        <td><a href="delete_student.php?id=<?php echo htmlspecialchars($row['InterestID']); ?>">Delete</a></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No students found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <p><a href="index.php">Back to Dashboard</a></p>
</body>
</html>

<?php $conn->close(); ?>