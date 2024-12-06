<?php
// Include the config file that defines the database credentials
require_once '../config/database.php';

// Step 1: Check if the database exists and create it if it doesn't
try {
    // Create a PDO instance to connect to MySQL server
    $pdo = new PDO("mysql:host=" . DB_SERVER, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "`");
    echo "Database `" . DB_NAME . "` created or already exists.<br>";

    // Switch to the newly created database
    $pdo->exec("USE `" . DB_NAME . "`");
} catch (PDOException $e) {
    die("Database creation failed: " . $e->getMessage());
}

// Step 2: Path to the SQL script
$sql_file = '../sql/database_schema.sql';

// Check if the SQL file exists
if (!file_exists($sql_file)) {
    die("SQL file not found.");
}

try {
    // Read and execute the SQL script
    $sql = file_get_contents($sql_file);
    $statements = explode(';', $sql);

    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }

    echo "Database setup completed successfully!";
} catch (PDOException $e) {
    die("Error setting up the database: " . $e->getMessage());
}
?>
