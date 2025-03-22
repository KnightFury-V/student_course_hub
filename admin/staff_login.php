<?php
session_start();
include '../includes/db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffID = $_POST['staff_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Staff WHERE StaffID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $staffID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $staff = $result->fetch_assoc();
        if (password_verify($password, $staff['Password'])) {
            $_SESSION['staff_logged_in'] = true;
            $_SESSION['staff_id'] = $staff['StaffID'];
            header('Location: staff_dashboard.php');
            exit;
        } else {
            $error = 'Invalid Staff ID or Password.';
        }
    } else {
        $error = 'Invalid Staff ID or Password.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Login</title>
    <link rel="stylesheet" href="../css/stylesadminstafflogin.css">
</head>
<body>
    <div class="staff-login">
        <h1>Staff Login</h1>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="staff_id">Staff ID:</label>
            <input type="number" name="staff_id" id="staff_id" placeholder="Enter Your Staff ID"><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter Password"><br><br>
            <input type="submit" value="Login">
        </form>
        <p><a href="../admin/alllogin.php">Back to Main Login Page</a></p>
    </div>
</body>
</html>

<?php $conn->close(); ?>