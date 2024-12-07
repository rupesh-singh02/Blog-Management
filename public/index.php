<?php
session_start(); // Ensure session is started to handle login state

// Include necessary controllers
require_once '../controllers/LoginController.php';
require_once '../controllers/SignupController.php';
require_once '../controllers/DashboardController.php';
require_once '../controllers/AdminDashboardController.php';
require_once '../models/Blog.php';  // Include Blog model if needed for JSON endpoint

// Default action is to show the login page
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Instantiate controllers
$loginController = new LoginController();
$dashboardController = new DashboardController();
$signupController = new SignupController();
$adminController = new AdminDashboardController();

// Check if the request is for posts (AJAX call for posts)
if (isset($_GET['category'])) {
    $categoryId = $_GET['category'];
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Initialize Blog model
    $dbConnection = getDBConnection();
    $blogModel = new Blog($dbConnection);

    // Fetch posts based on category
    if ($categoryId === 'all') {
        $posts = $blogModel->getAllPosts(10, ($page - 1) * 10);
    } else {
        $posts = $blogModel->getPostsByCategory($categoryId, 10, ($page - 1) * 10);
    }

    // Return posts as JSON
    header('Content-Type: application/json');
    echo json_encode(['posts' => $posts]);
    exit; // Ensure no further code is executed
}

// Route to appropriate controller action for login or dashboard
switch ($action) {
    case 'signup':
        $signupController->signup(); // Show signup form
        break;

    case 'login':
        if (isset($_SESSION['user'])) {
            // If already logged in, redirect to dashboard
            header('Location: index.php?action=dashboard');
            exit;
        }
        $loginController->showLoginForm(); // Show login form
        break;

    case 'loginPost':
        $loginController->login(); // Handle login POST request
        break;

    case 'logout':
        $loginController->logout(); // Handle logout
        break;

    case 'dashboard':
        // Ensure user is logged in before accessing dashboard
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
            header('Location: index.php?action=login');
            exit;
        }
        $dashboardController->dashboard(); // Show dashboard
        break;
    case 'adminDashboard':
        $section = $_GET['section'] ?? 'users';
        $adminController->adminDashboard($section);
        break;

    case 'adminAction':
        $adminController->handleAction($_GET['action'], $_GET['type']);
        break;


    default:
        // Default action (show login page)
        $loginController->showLoginForm();
        break;
}
?>