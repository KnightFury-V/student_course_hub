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
    <link rel="stylesheet" href="../css/stylesadminprograms.css">
    
</head>
<body>
    <h1>Manage Programs</h1>
   <a href='add_program.php' class='button'> Add New Program </a>
  <a href="index.php">Back to Dashboard</a>

    <div class="admin-program-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="admin-program-item">';
                echo '<img src="../images/programs/' . $row['Image'] . '" alt="' . $row['ProgrammeName'] . '">';
                echo '<h2>' . $row['ProgrammeName'] . '</h2>';
                echo '<p><strong>ID:</strong> ' . $row['ProgrammeID'] . '</p>';
                echo '<p><strong>Level ID:</strong> ' . $row['LevelID'] . '</p>';
                echo '<p>' . substr($row['Description'], 0, 100) . '...</p>';
                echo '<p><a href="edit_program.php?id=' . $row['ProgrammeID'] . '">Edit</a> | <a href="delete_program.php?id=' . $row['ProgrammeID'] . '">Delete</a></p>';
                echo '</div>';
            }
        } else {
            echo '<p>No programs found.</p>';
        }
        ?>
    </div>
    
</body>
</html>

<?php $conn->close(); ?>