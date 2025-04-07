<?php
// Database connection
$db = new SQLite3('receipt.db');

// Create the table if it doesn't exist
$db->exec("CREATE TABLE IF NOT EXISTS submissions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    date TEXT,
    amount FLOAT,
    description TEXT,
    picture BLOB
)");

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    // Handle file upload
    $picture = null;
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        //Get the file and store it as a BLOB
        $picture = file_get_contents($_FILES['receipt']['tmp_name']);
    } else {
        echo "File upload failed.";
        exit;
    }

    // Prepare and execute the SQL statement
    $stmt = $db->prepare("INSERT INTO submissions (date, amount, description, picture) VALUES (:date, :amount, :description, :picture)");
    $stmt->bindValue(':date', $date, SQLITE3_TEXT);
    $stmt->bindValue(':amount', $amount, SQLITE3_FLOAT);
    $stmt->bindValue(':description', $description, SQLITE3_TEXT);
    $stmt->bindValue(':picture', $picture, SQLITE3_BLOB); 

    if ($stmt->execute()) {
        echo "Data submitted successfully!";
    } else {
        echo "Error: " . $stmt->lastErrorMsg();
    }
} else {
    echo "Invalid request method.";
}
?>

