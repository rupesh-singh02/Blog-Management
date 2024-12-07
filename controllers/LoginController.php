<?php
require_once '../models/User.php';

class LoginController {

    // Show login form
    public function showLoginForm() {
        include '../views/login.php';
    }

    // Handle login
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Check credentials using the User model
            $userModel = new User();
            $user = $userModel->checkLogin($username, $password);

            if ($user) {
                // Set session variables and redirect to dashboard
                $_SESSION['user'] = $user;
                if ($user['role'] === 'admin') {
                    header('Location: index.php?action=adminDashboard');
                } else {
                    header('Location: index.php?action=dashboard');
                }
                exit;
            } else {
                // Show error if login fails
                $loginError = "Invalid username or password.";
                include '../views/login.php';
            }
        }
    }

    // Handle logout
    public function logout() {
        // Destroy session and redirect to login page
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }
}
?>
