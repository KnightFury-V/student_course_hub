<?php
/**
 * Create Admin User Page
 *
 * Allows superusers to create admin user accounts.
 *
 * @package AdminCreateAdmin
 */

session_start();
include '../includes/db_connect.php';
include '../includes/functions.php'; // Include functions.php to access isSuperuser

// Check if admin is logged in and is a superuser
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || !isSuperuser($conn, $_SESSION['admin_username'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if username already exists
        $checkSql = "SELECT Username FROM Admins WHERE Username = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $error = 'Username already exists.';
        } else {
            // Insert admin user into database
            $sql = "INSERT INTO Admins (Username, Password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                $success = 'Admin user created successfully.';
            } else {
                $error = 'Error creating admin user.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Admin User</title>
    <link rel="stylesheet" href="../css/stylesadmincreateuser.css">
</head>
<body>
    <div class="admin-create">
        <h1>Create Admin User</h1>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required><br><br>
            <input type="submit" value="Create Admin">
        </form><br>
        <p><a href="index.php">Back to Dashboard</a></p>
    </div>
</body>
</html>

<?php $conn->close(); ?>