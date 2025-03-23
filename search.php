<?php
/**
 * Search Results Page
 *
 * Displays search results for programs.
 *
 * @package SearchResults
 */

include 'includes/db_connect.php';

$searchTerm = isset($_GET['search']) ? filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$searchResults = [];

if (!empty($searchTerm)) {
    $searchTerm = "%" . $searchTerm . "%";

    $sql = "SELECT ProgrammeID, ProgrammeName, Description, Image FROM Programmes WHERE ProgrammeName LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="css/stylessearch.css">
</head>
<body>
    <h1>Search Results</h1>

    <div class="search-admin-container">
        <form method="get" action="search.php" class="search-form">
            <input type="text" name="search" placeholder="Search programs here...." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <input type="submit" value="Search">
        </form>
    </div>

    <div class="program-grid">
        <?php if (!empty($searchTerm)): ?>
            
            <?php if (!empty($searchResults)): ?>
                <?php foreach ($searchResults as $program): ?>
                    <div class="program-item">
                        <img src="images/programs/<?php echo htmlspecialchars($program['Image']); ?>" alt="<?php echo htmlspecialchars($program['ProgrammeName']); ?>">
                        <h2><a href="program.php?id=<?php echo htmlspecialchars($program['ProgrammeID']); ?>"><?php echo htmlspecialchars($program['ProgrammeName']); ?></a></h2>
                        <p><?php echo htmlspecialchars(substr($program['Description'], 0, 150)); ?>...</p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No programs found.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <p><a href="index.php">Back to Homepage</a></p>
</body>
</html>

<?php $conn->close(); ?>