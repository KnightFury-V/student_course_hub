<?php
session_start();
if (!isset($_SESSION['staff_logged_in']) || $_SESSION['staff_logged_in'] !== true) {
    header('Location: staff_login.php');
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/db_connect.php';

$staffID = $_SESSION['staff_id'];

// Fetch staff name
$sqlStaffName = "SELECT Name FROM Staff WHERE StaffID = ?";
$stmtStaffName = $conn->prepare($sqlStaffName);
$stmtStaffName->bind_param("i", $staffID);

if ($stmtStaffName->execute()) {
    $resultStaffName = $stmtStaffName->get_result();
    $staff = $resultStaffName->fetch_assoc();
    $staffName = $staff['Name'];
} else {
    echo "Database error (Staff Name): " . $stmtStaffName->error;
    $staffName = "Staff Member"; // Default name in case of error
}

// Fetch modules led by the staff member
$sqlModules = "SELECT Modules.* FROM Modules WHERE ModuleLeaderID = ?";
$stmtModules = $conn->prepare($sqlModules);
$stmtModules->bind_param("i", $staffID);

if ($stmtModules->execute()) {
    $resultModules = $stmtModules->get_result();
    $modules = $resultModules->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Database error (Modules): " . $stmtModules->error;
    $modules = []; // Ensure $modules is defined even if there's an error
}

// Fetch programmes led by the staff member
$sqlProgrammes = "SELECT Programmes.* FROM Programmes WHERE ProgrammeLeaderID = ?";
$stmtProgrammes = $conn->prepare($sqlProgrammes);
$stmtProgrammes->bind_param("i", $staffID);

if ($stmtProgrammes->execute()) {
    $resultProgrammes = $stmtProgrammes->get_result();
    $programmes = $resultProgrammes->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Database error (Programmes): " . $stmtProgrammes->error;
    $programmes = []; // Ensure $programmes is defined even if there's an error
}

//Fetch programmes that contain the modules the staff member leads.
$programmesWithModules = [];
foreach ($modules as $module) {
    $moduleID = $module['ModuleID'];
    $sqlProgrammesWithModules = "SELECT Programmes.* FROM ProgrammeModules JOIN Programmes ON ProgrammeModules.ProgrammeID = Programmes.ProgrammeID WHERE ProgrammeModules.ModuleID = ?";
    $stmtProgrammesWithModules = $conn->prepare($sqlProgrammesWithModules);
    $stmtProgrammesWithModules->bind_param("i", $moduleID);

    if ($stmtProgrammesWithModules->execute()) {
        $resultProgrammesWithModules = $stmtProgrammesWithModules->get_result();
        $programmesWithModules = array_merge($programmesWithModules, $resultProgrammesWithModules->fetch_all(MYSQLI_ASSOC));
    } else {
        echo "Database error (Programmes with Modules): " . $stmtProgrammesWithModules->error;
    }
}
$programmesWithModules = array_unique($programmesWithModules, SORT_REGULAR);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="../css/stylesadminstaff_dashboard.css">
</head>
<body>
    
    <h1>Welcome, <?php echo htmlspecialchars($staffName); ?>!</h1>
    <div class="content">
    <h2>Modules You Lead:</h2>
    <?php if (!empty($modules)): ?>
        <ul>
            <?php foreach ($modules as $module): ?>
                <li><?php echo $module['ModuleName']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You do not lead any modules.</p>
    <?php endif; ?>

    <h2>Programmes You Lead:</h2>
    <?php if (!empty($programmes)): ?>
        <ul>
            <?php foreach ($programmes as $programme): ?>
                <li><?php echo $programme['ProgrammeName']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You do not lead any programmes.</p>
    <?php endif; ?>

    <h2>Programmes Containing Your Modules:</h2>
    <?php if (!empty($programmesWithModules)): ?>
        <ul>
            <?php foreach ($programmesWithModules as $programme): ?>
                <li><?php echo $programme['ProgrammeName']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Your modules are not in any programmes.</p>
    <?php endif; ?>

    <p><a href="staff_logout.php">Logout</a></p>
    </div>
</body>
</html>

<?php $conn->close(); ?>