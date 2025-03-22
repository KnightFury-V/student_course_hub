<?php
/**
 * Edit Program Page
 *
 * Allows admins to edit existing program details.
 *
 * @package AdminEditProgram
 */

session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

// Get program ID from URL
$programID = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : 0;

if (!$programID) {
    echo "Invalid program ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programName = filter_input(INPUT_POST, 'program_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $levelID = filter_input(INPUT_POST, 'level_id', FILTER_VALIDATE_INT);
    $programmeLeaderID = filter_input(INPUT_POST, 'programme_leader_id', FILTER_VALIDATE_INT);

    // Validate inputs
    if (!$programName || !$description || !$image || !$levelID || !$programmeLeaderID) {
        $error = "Please fill in all fields.";
    } else {
        // Update program in database
        $sql = "UPDATE Programmes SET ProgrammeName = ?, Description = ?, Image = ?, LevelID = ?, ProgrammeLeaderID = ? WHERE ProgrammeID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiii", $programName, $description, $image, $levelID,$programmeLeaderID, $programID);

        if ($stmt->execute()) {
            $success = 'Program updated successfully.';
        } else {
            $error = 'Error updating program.';
        }
    }
}

// Fetch program details
$sql = "SELECT ProgrammeName, Description, Image, LevelID, ProgrammeLeaderID FROM Programmes WHERE ProgrammeID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $programID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $program = $result->fetch_assoc();
} else {
    echo "Program not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Program</title>
    <link rel="stylesheet" href="../css/stylesadminedit_program.css">
</head>
<body>
    <h1>Edit Program</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <div class="add-form">
    <form method="post">
        <label for="program_name">Program Name:</label>
        <input type="text" name="program_name" id="program_name" value="<?php echo htmlspecialchars($program['ProgrammeName']); ?>" required><br><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo htmlspecialchars($program['Description']); ?></textarea><br><br>
        <label for="image">Image Filename:</label>
        <input type="text" name="image" id="image" value="<?php echo htmlspecialchars($program['Image']); ?>" required><br><br>
        <label for="level_id">Level ID:</label>
        <input type="number" name="level_id" id="level_id" value="<?php echo htmlspecialchars($program['LevelID']); ?>" required><br><br>
        <label for="programme_leader_id">Programme Leader ID:</label>
        <input type="number" name="programme_leader_id" id="programme_leader_id" value="<?php echo htmlspecialchars($program['ProgrammeLeaderID']); ?>" required><br><br>
        <input type="submit" value="Update Program">
    </form>
    </div>
    <p><a href="programs.php">Back to Programs</a></p>
</body>
</html>

<?php $conn->close(); ?>