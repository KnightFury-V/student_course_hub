<?php
/**
 * Create Superuser Page
 *
 * Allows creation of superuser accounts. Should only be accessible to existing superusers.
 *
 * @package AdminCreateSuperuser
 */

include '../includes/db_connect.php';

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
            // Insert superuser into database
            $sql = "INSERT INTO Admins (Username, Password, IsSuperuser) VALUES (?, ?, TRUE)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                $success = 'Superuser created successfully.';
            } else {
                $error = 'Error creating superuser.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Superuser</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="admin-create">
        <h1>Create Superuser</h1>
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
            <input type="submit" value="Create Superuser">
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>