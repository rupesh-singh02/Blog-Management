<?php
// Include the config file to access the database connection function
require_once '../config/database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = getDBConnection(); // Use the available DB connection
    }

    // Function to check if the user already exists
    public function checkIfUserExists($username, $email)
    {
        $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? true : false; // Return true if user exists
    }

    // Function to create a new user
    public function register($username, $email, $password)
    {
        // Insert new user into the database
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        return $stmt->execute(); // Return true if the user is registered
    }

    // Function to check user credentials for login
    public function checkLogin($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Login successful
        }
        return false; // Login failed
    }

    // Function to get all users
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users"; // Fetching basic info only
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all users as an array
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function storePasswordResetToken($userId, $token, $expiresAt)
    {
        $sql = "INSERT INTO reset_password_token (user_id, token, expiresAt) VALUES (:user_id, :token, :expiresAt)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->bindParam(':expiresAt', $expiresAt, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function isValidToken($token)
    {
        $sql = "SELECT * FROM reset_password_token WHERE token = :token AND expiresAt > NOW() LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function getUserIdByToken($token)
    {
        $sql = "SELECT user_id FROM reset_password_token WHERE token = :token LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function deleteToken($token)
    {
        $sql = "DELETE FROM reset_password_token WHERE token = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updatePassword($userId, $hashedPassword)
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Function to update a user's details
    public function updateUser($data)
    {
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
        $stmt->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Function to delete a user
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);

        return $stmt->execute(); // Return true if user is deleted
    }
}
?>