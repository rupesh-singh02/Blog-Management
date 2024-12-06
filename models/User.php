<?php
// Include the config file to access the database connection function
require_once '../config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = getDBConnection(); // Now this function is available
    }

    // Function to check if the user already exists
    public function checkIfUserExists($username, $email) {
        $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? true : false;  // Return true if user exists
    }

    // Function to create a new user
    public function register($username, $email, $password) {
        // Check if the user already exists
        $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            // User already exists, return false
            return false;
        }

        // Insert new user into the database
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            return true;  // User registered successfully
        }
        return false;  // Registration failed
    }

    // Function to check user credentials for login
    public function checkLogin($username, $password) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;  // Login successful
        }
        return false;  // Login failed
    }
}
?>
