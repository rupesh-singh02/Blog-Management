<?php
require_once '../models/Blog.php';
require_once '../config/database.php';  // Include database connection

class DashboardController
{
    private $blogModel;

    public function __construct()
    {
        // Initialize Blog model with a database connection
        $dbConnection = getDBConnection();  // Assuming this function returns the PDO connection
        $this->blogModel = new Blog($dbConnection);
    }

    // Show the dashboard
    public function dashboard($page = 1, $selectedCategory = 'all')
    {
        // Pagination variables
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Fetch categories and posts
        $categories = $this->blogModel->getCategories();
        $posts = $selectedCategory === 'all'
            ? $this->blogModel->getAllPosts($limit, $offset)
            : $this->blogModel->getPostsByCategory((int) $selectedCategory, $limit, $offset);

        // Debugging to verify data
        if (empty($categories) || empty($posts)) {
            die('Debugging: Ensure categories and posts are fetched correctly.');
        }

        // Prepare the inner content of the dashboard view
        $dashboardContent = $this->renderView('dashboard', [
            'categories' => $categories,
            'posts' => $posts,
        ]);

        // Pass dashboard content into the layout
        echo $this->renderView('layout/app', [
            'content' => $dashboardContent, // Inject dynamic content
            'pageTitle' => 'Dashboard',    // Page-specific title
        ]);
    }


    // Render views
    private function renderView($view, $data = [])
    {
        extract($data); // Extract the data array into variables
        $viewPath = "../views/$view.php";

        // Debugging to check if the file exists
        if (!file_exists($viewPath)) {
            die("View file not found: $viewPath");
        }

        ob_start(); // Start output buffering
        include_once $viewPath;
        return ob_get_clean(); // Return the captured output
    }

}
?>