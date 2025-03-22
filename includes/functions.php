<?php
/**
 * Utility Functions
 *
 * Provides helper functions for database interactions and data retrieval.
 *
 * @package UtilityFunctions
 */

/**
 * Retrieves the name of a staff member based on their ID.
 *
 * @param mysqli $conn The database connection object.
 * @param int $staffID The ID of the staff member.
 * @return string The name of the staff member or 'Unknown Leader' if not found.
 */
function getStaffName($conn, $staffID) {
    $staffID = filter_var($staffID, FILTER_VALIDATE_INT);
    if (!$staffID) {
        return 'Invalid Staff ID';
    }

    $sql = "SELECT Name FROM Staff WHERE StaffID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $staffID);
    $stmt->execute();
    $result = $stmt->get_result();
    return ($result->num_rows > 0) ? htmlspecialchars($result->fetch_assoc()['Name']) : 'Unknown Leader';
}

/**
 * Retrieves the name of a level based on its ID.
 *
 * @param mysqli $conn The database connection object.
 * @param int $levelID The ID of the level.
 * @return string The name of the level or 'Unknown Level'if not found.
 */
function getLevelName($conn, $levelID) {
    $levelID = filter_var($levelID, FILTER_VALIDATE_INT);
    if (!$levelID) {
        return 'Invalid Level ID';
    }

    $sql = "SELECT LevelName FROM Levels WHERE LevelID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $levelID);
    $stmt->execute();
    $result = $stmt->get_result();
    return ($result->num_rows > 0) ? htmlspecialchars($result->fetch_assoc()['LevelName']) : 'Unknown Level';
}

/**
 * Checks if an admin user is a superuser.
 *
 * @param mysqli $conn The database connection object.
 * @param string $username The username of the admin.
 * @return bool True if the admin is a superuser, false otherwise.
 */
function isSuperuser($conn, $username) {
    $sql = "SELECT IsSuperuser FROM Admins WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return (bool) $result->fetch_assoc()['IsSuperuser'];
    }
    return false;
}

/**
 * Retrieves the name of a program based on its ID.
 *
 * @param mysqli $conn The database connection object.
 * @param int $programID The ID of the program.
 * @return string The name of the program or 'Unknown Program' if not found.
 */
function getProgramName($conn, $programID) {
    $sql = "SELECT ProgrammeName FROM Programmes WHERE ProgrammeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $programID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['ProgrammeName'];
    } else {
        return null;
    }
}
?>