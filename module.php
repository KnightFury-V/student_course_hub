<?php
/**
 * Module Details Page
 *
 * Displays details of a specific module and the programs it is involved in.
 *
 * @package ModuleDetails
 */

include 'includes/db_connect.php';
include 'includes/functions.php';

// Get the module ID from the URL
$moduleID = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : 0;

if (!$moduleID) {
    echo "Invalid module ID.";
    exit;
}

// Fetch module details
$sql = "SELECT m.ModuleID, m.ModuleName, m.Description, m.Image, m.ModuleLeaderID 
        FROM Modules m 
        WHERE m.ModuleID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $moduleID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $module = $result->fetch_assoc();
    $leaderName = getStaffName($conn, $module['ModuleLeaderID']);

    if (!$leaderName) {
        $leaderName = "Leader Not Found";
    }
} else {
    echo "Module not found.";
    exit;
}

// Fetch programs associated with the module
$programsSql = "SELECT p.ProgrammeID, p.ProgrammeName 
                FROM Programmes p 
                INNER JOIN ProgrammeModules pm ON p.ProgrammeID = pm.ProgrammeID 
                WHERE pm.ModuleID = ?";
$programsStmt = $conn->prepare($programsSql);
$programsStmt->bind_param("i", $moduleID);
$programsStmt->execute();
$programsResult = $programsStmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($module['ModuleName']); ?></title>
    <link rel="stylesheet" href="css/stylesmainmodule.css">
</head>
<body>
<div class="module-details">
    <h1><?php echo htmlspecialchars($module['ModuleName']); ?></h1>
    <img src="images/modules/<?php echo htmlspecialchars($module['Image']); ?>" alt="<?php echo htmlspecialchars($module['ModuleName']); ?>">
    <p><strong>Module Leader:</strong> <?php echo htmlspecialchars($leaderName); ?></p>
    <p><?php echo htmlspecialchars($module['Description']); ?></p>

    <h2>Programs Involved</h2>
    <ul>
        <?php while ($program = $programsResult->fetch_assoc()): ?>
            <ol><a href="program.php?id=<?php echo htmlspecialchars($program['ProgrammeID']); ?>"><?php echo htmlspecialchars($program['ProgrammeName']); ?></a></ol>
        <?php endwhile; ?>
    </ul> <br>

    <p><a href="index.php"><strong>Back to Homepage</strong></a></p>
</div>
</body>
</html>

<?php $conn->close(); ?>