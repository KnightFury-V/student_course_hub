<?php
/**
 * Database Connection Script
 *
 * This script establishes a connection to the MySQL database using MySQLi.
 * If the connection fails, an error message is displayed, and the script is terminated.
 *
 * @package DatabaseConnection
 */

/**
 * Database credentials
 *
 * @var string $servername The hostname of the database server.
 * @var string $username   The username for the database connection.
 * @var string $password   The password for the database connection.
 * @var string $dbname     The name of the database to connect to.
 */
$servername = "localhost";
$username = "root";  // Your database username
$password = "";      // Your database password
$dbname = "student_course_hub";

/**
 * Create a new MySQLi connection
 *
 * @var mysqli $conn The MySQLi connection object.
 */
$conn = new mysqli($servername, $username, $password, $dbname);

/**
 * Check the database connection
 *
 * If the connection fails, an error message is displayed, and the script terminates.
 */
if ($conn->connect_error) {
    die("Database connection failed. Please check your credentials or server status.");
}
?>