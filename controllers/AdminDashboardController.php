<?php
require_once '../models/User.php';
require_once '../models/Blog.php';
require_once '../config/database.php';

class AdminDashboardController
{
    private $userModel;
    private $blogModel;

    public function __construct()
    {
        // Initialize models with a database connection
        $dbConnection = getDBConnection();
        $this->userModel = new User($dbConnection);
        $this->blogModel = new Blog($dbConnection);
    }

    // Show the admin dashboard
    public function adminDashboard($section = 'users')
    {
        $data = [];
        $pageTitle = 'Admin Dashboard';

        // Handle different sections
        if ($section === 'users') {
            $data['users'] = $this->userModel->getAllUsers();
        } elseif ($section === 'blogs') {
            $data['blogs'] = $this->blogModel->getAllPosts(1000, 0); // Fetch all blogs without pagination
        }

        // Render the admin dashboard view
        $adminContent = $this->renderView('admin_dashboard', [
            'section' => $section,
            'data' => $data,
        ]);

        // Pass admin content into the layout
        echo $this->renderView('layout/app', [
            'content' => $adminContent,
            'pageTitle' => $pageTitle,
        ]);
    }

    // Handle actions for users and blogs
    public function handleAction($action, $type)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if ($type === 'user') {
                    if ($action === 'add') {
                        $this->userModel->addUser([
                            'username' => $_POST['username'],
                            'email' => $_POST['email'],
                            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                        ]);
                    } elseif ($action === 'update') {
                        $this->userModel->updateUser([
                            'id' => $_POST['id'],
                            'username' => $_POST['username'],
                            'email' => $_POST['email'],
                        ]);
                    } elseif ($action === 'delete') {
                        $this->userModel->deleteUser((int)$_POST['id']);
                    }
                } elseif ($type === 'blog') {
                    if ($action === 'add') {
                        $this->blogModel->addPost(
                            $_POST['title'],
                            $_POST['content'],
                            (int)$_POST['category_id'],
                            $_POST['published_at']
                        );
                    } elseif ($action === 'update') {
                        $this->blogModel->updatePost(
                            (int)$_POST['id'],
                            $_POST['title'],
                            $_POST['content'],
                            (int)$_POST['category_id'],
                            $_POST['published_at']
                        );
                    } elseif ($action === 'delete') {
                        $this->blogModel->deletePost((int)$_POST['id']);
                    }
                }

                // Redirect back to the appropriate section
                header('Location: index.php?action=adminDashboard&section=' . $type . 's');
                exit;
            } catch (Exception $e) {
                die('Error: ' . $e->getMessage()); // Handle any exceptions
            }
        }
    }

    // Render views
    private function renderView($view, $data = [])
    {
        extract($data); // Extract the data array into variables
        $viewPath = "../views/$view.php";

        if (!file_exists($viewPath)) {
            die("View file not found: $viewPath");
        }

        ob_start(); // Start output buffering
        include_once $viewPath;
        return ob_get_clean(); // Return the captured output
    }
}
?>
