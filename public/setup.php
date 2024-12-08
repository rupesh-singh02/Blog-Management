<?php
// Include the config file that defines the database credentials
require_once '../config/database.php';
require_once '../email_templates/welcome.php';
require_once '../email_templates/forgotpassword.php';

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

// Step 3: Adding email templates
try {
    insertEmailTemplate();
    insertForgotPasswordTemplate();
    echo "Email template uploaded successfully!";
} catch (PDOException $e) {
    die("Error applying email template: " . $e->getMessage());
}

// Step 4: Insert initial data into the 'users' and 'categories' tables

// Insert 1 admin user
try {
    $adminPassword = password_hash('admin123', PASSWORD_BCRYPT); // Hash the password
    $sql = "INSERT INTO users (username, email, password, role) VALUES 
            ('admin', 'admin@gmail.com', :password, 'admin')";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':password', $adminPassword);
    $stmt->execute();
    echo "Admin user inserted successfully!<br>";
} catch (PDOException $e) {
    die("Error inserting admin user: " . $e->getMessage());
}

// Insert 5 categories
try {
    $categories = [
        ['name' => 'Technology', 'description' => 'All about technology.'],
        ['name' => 'Health', 'description' => 'Health-related articles and news.'],
        ['name' => 'Travel', 'description' => 'Travel experiences and tips.'],
        ['name' => 'Education', 'description' => 'Educational resources and insights.'],
        ['name' => 'Lifestyle', 'description' => 'Lifestyle trends and advice.']
    ];

    $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
    $stmt = $pdo->prepare($sql);

    foreach ($categories as $category) {
        $stmt->bindParam(':name', $category['name']);
        $stmt->bindParam(':description', $category['description']);
        $stmt->execute();
    }

    echo "Categories inserted successfully!<br>";
} catch (PDOException $e) {
    die("Error inserting categories: " . $e->getMessage());
}
?>