<?php
/**
 * Program Details Page
 *
 * Displays details of a specific program, including modules.
 *
 * @package ProgramDetails
 */

include 'includes/db_connect.php';
include 'includes/functions.php'; // Include functions.php to access getStaffName and getLevelName

$programID = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : 0;

if (!$programID) {
    echo "Invalid program ID.";
    exit;
}

$sql = "SELECT ProgrammeID, ProgrammeName, Description, Image, LevelID, ProgrammeLeaderID FROM Programmes WHERE ProgrammeID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $programID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $program = $result->fetch_assoc();
    $levelName = getLevelName($conn, $program['LevelID']);
    $leaderName = getStaffName($conn, $program['ProgrammeLeaderID']);

    if (!$leaderName) {
        $leaderName = "Leader Not Found";
    }
    if (!$levelName) {
        $levelName = "Level Not Found";
    }

    $moduleSql = "SELECT m.ModuleID, m.ModuleName, m.ModuleLeaderID, pm.Year FROM Modules m INNER JOIN ProgrammeModules pm ON m.ModuleID = pm.ModuleID WHERE pm.ProgrammeID = ? ORDER BY pm.Year";
    $moduleStmt = $conn->prepare($moduleSql);
    $moduleStmt->bind_param("i", $programID);
    $moduleStmt->execute();
    $moduleResult = $moduleStmt->get_result();

    $modulesByYear = [];
    while ($moduleRow = $moduleResult->fetch_assoc()) {
        $modulesByYear[$moduleRow['Year']][] = $moduleRow;
    }

} else {
    echo "Program not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($program['ProgrammeName']); ?></title>
    <link rel="stylesheet" href="css/stylesmainprogram.css">
</head>
<body>

    <div class="program-details">

        <h1><?php echo htmlspecialchars($program['ProgrammeName']); ?></h1>
        <img src="images/programs/<?php echo htmlspecialchars($program['Image']); ?>" alt="<?php echo htmlspecialchars($program['ProgrammeName']); ?>">
        <p><strong>Level:</strong> <?php echo htmlspecialchars($levelName); ?></p>
        <p><strong>Programme Leader:</strong> <?php echo htmlspecialchars($leaderName); ?></p>
        <p><?php echo htmlspecialchars($program['Description']); ?></p>

        <h2>Modules</h2>
        <?php foreach ($modulesByYear as $year => $modules): ?>
            <h3>Year <?php echo htmlspecialchars($year); ?></h3>
            <ul>
                <?php foreach ($modules as $module): ?>
                    <li>
                        <a href="module.php?id=<?php echo htmlspecialchars($module['ModuleID']); ?>"><?php echo htmlspecialchars($module['ModuleName']); ?></a> (Leader: <?php echo htmlspecialchars(getStaffName($conn, $module['ModuleLeaderID']) ?: "Leader Not Found"); ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
        <p><a href="index.php">Back to Homepage</a></p>
    </div>
</body>
</html>

<?php $conn->close(); ?>