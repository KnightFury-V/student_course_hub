<?php
/**
 * Main Index Page
 *
 * Displays available programs and allows students to register or withdraw interest.
 *
 * @package StudentCourseHub
 */

session_start();
include 'includes/db_connect.php';
include 'includes/functions.php';

$selectedLevel = isset($_GET['level']) ? filter_input(INPUT_GET, 'level', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : 'all';

// Fetch programs based on level
$result = fetchProgramsByLevel($conn, $selectedLevel);

$registerSuccess = isset($_SESSION['register_success']) ? $_SESSION['register_success'] : '';
$registerError = isset($_SESSION['register_error']) ? $_SESSION['register_error'] : '';
$withdrawSuccess = isset($_SESSION['withdraw_success']) ? $_SESSION['withdraw_success'] : '';
$withdrawError = isset($_SESSION['withdraw_error']) ? $_SESSION['withdraw_error'] : '';

unset($_SESSION['register_success']);
unset($_SESSION['register_error']);
unset($_SESSION['withdraw_success']);
unset($_SESSION['withdraw_error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register_interest'])) {
        $programID = filter_input(INPUT_POST, 'program_id', FILTER_VALIDATE_INT);
        $studentName = filter_input(INPUT_POST, 'student_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        // Check for duplicates
        if (isDuplicateInterest($conn, $programID, $email)) {
            $_SESSION['register_error'] = "You have already registered interest for this program.";
        } else {
            if (registerInterest($conn, $programID, $studentName, $email)) {
                $_SESSION['register_success'] = "Interest registered successfully!";
            } else {
                $_SESSION['register_error'] = "Error registering interest.";
            }
        }
        header('Location: index.php#register');
        exit;
    } elseif (isset($_POST['withdraw_interest'])) {
        $programID = filter_input(INPUT_POST, 'program_id', FILTER_VALIDATE_INT);
        $studentName = filter_input(INPUT_POST, 'student_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if (withdrawInterest($conn, $programID, $email)) {
            $_SESSION['withdraw_success'] = "Interest withdrawn successfully!";
        } else {
            $_SESSION['withdraw_error'] = "Error withdrawing interest.";
        }
        header('Location: index.php#register');
        exit;
    }
}

// Function to fetch programs based on level
function fetchProgramsByLevel($conn, $selectedLevel) {
    if ($selectedLevel === 'all') {
        $sql = "SELECT ProgrammeID, ProgrammeName, Description, Image FROM Programmes";
        return $conn->query($sql);
    } else {
        $levelSql = "SELECT LevelID FROM Levels WHERE LevelName = ?";
        $levelStmt = $conn->prepare($levelSql);
        $levelStmt->bind_param("s", $selectedLevel);
        $levelStmt->execute();
        $levelResult = $levelStmt->get_result();

        if ($levelResult->num_rows > 0) {
            $levelID = $levelResult->fetch_assoc()['LevelID'];
            $sql = "SELECT ProgrammeID, ProgrammeName, Description, Image FROM Programmes WHERE LevelID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $levelID);
            $stmt->execute();
            return $stmt->get_result();
        } else {
            return null;
        }
    }
}

// Function to check for duplicate interest
function isDuplicateInterest($conn, $programID, $email) {
    $checkSql = "SELECT * FROM InterestedStudents WHERE ProgrammeID = ? AND Email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("is", $programID, $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    return $checkResult->num_rows > 0;
}

// Function to register interest
function registerInterest($conn, $programID, $studentName, $email) {
    $sql = "INSERT INTO InterestedStudents (ProgrammeID, StudentName, Email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $programID, $studentName, $email);
    return $stmt->execute();
}

// Function to withdraw interest
function withdrawInterest($conn, $programID, $email) {
    $sqlWithdraw = "DELETE FROM InterestedStudents WHERE Email = ? AND ProgrammeID = ?";
    $stmtWithdraw = $conn->prepare($sqlWithdraw);
    $stmtWithdraw->bind_param("si", $email, $programID);
    $stmtWithdraw->execute();
    return $stmtWithdraw->affected_rows > 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Course Hub - Programs</title>
    <link rel="stylesheet" href="css/stylesmainindex.css">
</head>
<body>
    <header>
        <h1>WELCOME TO STUDENT COURSE HUB <br> AVAILABLE PROGRAMS</h1>

        <div class="search-admin-container">
            <form method="get" action="search.php" class="search-form">
                <label for="search" class="visually-hidden"></label>
                <input type="text" name="search" id="search" placeholder="Search programs..." required>
                <input type="submit" value="Search">
            </form>
        </div>
        <div class="buttonindex">
            <a href="admin/alllogin.php" class="admin-login-button" target="_blank"><button>LOGIN</button></a>
        </div>
        <nav aria-label="Interest navigation">
            <a href="#register">Register/ Withdraw Interest</a>
        </nav>
    </header>

    <form method="get">
        <label style="color: black;" for="level"><strong>Filter by Level:</strong></label>
        <select name="level" id="level" onchange="this.form.submit()">
            <option value="all" <?php if ($selectedLevel === 'all') echo 'selected'; ?>>All</option>
            <option value="Undergraduate" <?php if ($selectedLevel === 'Undergraduate') echo 'selected'; ?>>Undergraduate</option>
            <option value="Postgraduate" <?php if ($selectedLevel === 'Postgraduate') echo 'selected'; ?>>Postgraduate</option>
        </select>
    </form>

    <div class="program-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $programmeID = $row['ProgrammeID'];
                $programmeName = $row['ProgrammeName'];

                echo '<div class="program-item">';
                echo '<img src="images/programs/' . htmlspecialchars($row['Image']) . '" alt="' . htmlspecialchars($programmeName) . '">';
                echo '<h2><a href="program.php?id=' . htmlspecialchars($programmeID) . '">' . htmlspecialchars($programmeName) . '</a></h2>';
                echo '</div>';
            }
        } elseif ($result) {
            echo "No programs found for the selected level.";
        } elseif ($selectedLevel !== 'all') {
            echo 'Invalid level selection';
        } else {
            echo 'No programs available';
        }
        ?>
    </div>

    <div class="register-interest" id="register">
        <h2>Register/ Withdraw Your Interest</h2>
        <?php if ($registerSuccess): ?>
            <p style="color: green;"><?php echo htmlspecialchars($registerSuccess); ?></p>
        <?php endif; ?>
        <?php if ($registerError): ?>
            <p style="color: red;"><?php echo htmlspecialchars($registerError); ?></p>
        <?php endif; ?>
        <?php if ($withdrawSuccess): ?>
            <p style="color: green;"><?php echo htmlspecialchars($withdrawSuccess); ?></p>
        <?php endif; ?>
        <?php if ($withdrawError): ?>
            <p style="color: red;"><?php echo htmlspecialchars($withdrawError); ?></p>
        <?php endif; ?>

        <?php
        // Check if there are any registered interests
        $checkInterestSql = "SELECT * FROM InterestedStudents";
        $checkInterestResult = $conn->query($checkInterestSql);
        if ($checkInterestResult && $checkInterestResult->num_rows > 0): ?>
            <form method="post">
                <label for="program_id">Select Program:</label>
                <select name="program_id" id="program_id" required>
                    <?php
                    include 'includes/db_connect.php';
                    $programSql = "SELECT ProgrammeID, ProgrammeName FROM Programmes";
                    $programResult = $conn->query($programSql);
                    if ($programResult && $programResult->num_rows > 0) {
                        while ($programRow = $programResult->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($programRow['ProgrammeID']) . '">' . htmlspecialchars($programRow['ProgrammeName']) . '</option>';
                        }
                    }
                    ?>
                </select>
                <label for="student_name">Name:</label>
                <input type="text" name="student_name" id="student_name" required>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                <input type="submit" name="register_interest" value="Register">
                <input type="submit" name="withdraw_interest" value="Withdraw">
            </form>
        <?php else: ?>
            <p>No data to withdraw.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y M"); ?> Student Course Hub. All rights reserved.</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>