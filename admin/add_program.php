<?php
/**
 * Add Program Page
 *
 * Allows admins to add new programs.
 *
 * @package AdminAddProgram
 */

session_start();
include '../includes/db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programName = htmlspecialchars($_POST['program_name'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
    $levelID = filter_input(INPUT_POST, 'level_id', FILTER_VALIDATE_INT);
    $programmeLeaderID = filter_input(INPUT_POST, 'programme_leader_id', FILTER_VALIDATE_INT);

    // Validate inputs
    if (!$programName || !$description || !$image || !$levelID || !$programmeLeaderID) {
        $error = "Please fill in all fields.";
    } else {
        // Insert program into database
        $sql = "INSERT INTO Programmes (ProgrammeName, Description, Image, LevelID, ProgrammeLeaderID) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $programName, $description, $image, $levelID, $programmeLeaderID);

        if ($stmt->execute()) {
            $success = 'Program added successfully.';
            $_SESSION['program_success'] = $success;
            header('Location: programs.php');
            exit;
        } else {
            $error = 'Error adding program.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Program</title>
    <link rel="stylesheet" href="../css/stylesadminedit_program.css">
</head>
<body>
    <h1>Add Program</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>
    <div class="add-form">
        <form method="post">
            <label for="program_name">Program Name:</label>
            <input type="text" name="program_name" id="program_name" required><br><br>
            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea><br><br>
            <label for="image">Image Filename:</label>
            <input type="text" name="image" id="image" required><br><br>
            <label for="level_id">Level ID:</label>
            <input type="number" name="level_id" id="level_id" required><br><br>
            <label for="programme_leader_id">Programme Leader ID:</label>
            <input type="number" name="programme_leader_id" id="programme_leader_id" required><br><br>
            <input type="submit" value="Add Program">
        </form>
    </div>
    <p><a href="programs.php">Back to Programs</a></p>
</body>
</html>

<?php $conn->close(); ?>