<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unagi";

// Establish a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the search term from the POST request
$searchTerm = $_POST['searchTerm'];

// Perform a search query across multiple tables
$sql = "SELECT * FROM books WHERE book_title LIKE '%$searchTerm%'
        UNION
        SELECT * FROM borrowed WHERE borrower_name LIKE '%$searchTerm%'
        UNION
        SELECT * FROM lostbooks WHERE lost_book_title LIKE '%$searchTerm%'
        UNION
        SELECT * FROM returned WHERE return_status LIKE '%$searchTerm%'";

$result = $conn->query($sql);

// Process the results
if ($result->num_rows > 0) {
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
} else {
    // No results found
    echo json_encode([]);
}

// Close the connection
$conn->close();
?>
