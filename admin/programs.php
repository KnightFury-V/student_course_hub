<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

include '../includes/db_connect.php';

$sql = "SELECT ProgrammeID, ProgrammeName, Description, Image, LevelID FROM Programmes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Programs</title>
    <link rel="stylesheet" href="../css/stylesadminmodules_programs.css">
</head>
<body>
    <a id="top"></a>
    <h1>Manage Programs</h1>
    <span>
    <a href="add_program.php" class="button">Add New Program</a>
    <a href="index.php" class="button">Back to Dashboard</a>
    <a href="#bottom" class="button">Go to Bottom</a>
    </span>
    <br>
    <div class="program-grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="program-item">
                    <img src="../images/programs/<?php echo htmlspecialchars($row['Image']); ?>" 
                         alt="<?php echo htmlspecialchars($row['ProgrammeName']); ?>">

                    <h2><?php echo htmlspecialchars($row['ProgrammeName']); ?></h2>
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($row['ProgrammeID']); ?></p>
                    <p><strong>Level:</strong> <?php echo htmlspecialchars($row['LevelID']); ?></p>
                    <p><?php echo htmlspecialchars(substr($row['Description'], 0, 100)); ?>...</p>
                    <a href="edit_program.php?id=<?php echo htmlspecialchars($row['ProgrammeID']); ?>">Edit</a> |
                    <a href="delete_program.php?id=<?php echo htmlspecialchars($row['ProgrammeID']); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-data">No programs found.</p>
        <?php endif; ?>
    </div>

    <a id="bottom"></a>
    <a href="#top" class="button">Go to Top</a>
</body>
</html>

<?php $conn->close(); ?>