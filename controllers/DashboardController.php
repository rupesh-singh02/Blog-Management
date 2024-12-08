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
        // Ensure $page is an integer
        $page = max(1, (int) $page);

        // Pagination variables
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Fetch categories and posts
        $categories = $this->blogModel->getCategories();
        $recentPosts = $this->blogModel->getRecentPosts();
        $topCommentedPosts = $this->blogModel->getTopCommentedPosts();
        $posts = $selectedCategory === 'all'
            ? $this->blogModel->getAllPosts($limit, $offset)
            : $this->blogModel->getPostsByCategory((int) $selectedCategory, $limit, $offset);

            // If section is blogs, fetch the categories and user's blogs
        if (isset($_GET['section']) && $_GET['section'] === 'blogs') {
            // Get the current user's ID from the session
            $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

            // Fetch the user's blogs if user is logged in
            if ($userId) {
                // Fetch all blog posts by the user (not just one by ID)
                $userBlogs = $this->blogModel->getPostsByUserId($userId);
            } else {
                $userBlogs = []; // No blogs to show if user is not logged in
            }

            if (isset($_GET['blog_id'])) {
                $data['blog'] = $this->blogModel->getPostById($_GET['blog_id']);
            }

            // Pass categories and the user's blogs to the view
            $data['categories'] = $categories;
            $data['blogs'] = $userBlogs; // Update to use $userBlogs instead of $posts
        }
        // Prepare the inner content of the dashboard view
        $dashboardContent = $this->renderView('dashboard', [
            'categories' => $categories,
            'recentPosts' => $recentPosts,
            'topCommentedPosts' => $topCommentedPosts,
            'posts' => $posts,
            'data' => isset($data) ? $data : [], // Add userBlogs if section is blogs
        ]);

        // Pass dashboard content into the layout
        echo $this->renderView('layout/app', [
            'content' => $dashboardContent, // Inject dynamic content
            'pageTitle' => 'Dashboard',    // Page-specific title
        ]);
    }

    public function handleAction($section, $task)
    {
        $messages = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {

                if ($task === 'add') {
                    $this->blogModel->addPost(
                        $_POST['title'],
                        $_POST['content'],
                        (int) $_SESSION['user']['id'],
                        (int) $_POST['category']
                    );
                    $messages['success'] = "Blog added successfully!";
                } elseif ($task === 'update') {
                    $this->blogModel->updatePost(
                        (int) $_POST['id'],
                        $_POST['title'],
                        $_POST['content'],
                        (int) $_SESSION['user']['id'],
                        (int) $_POST['category']
                    );
                    $messages['success'] = "Blog updated successfully!";
                } elseif ($task === 'delete') {
                    $this->blogModel->deletePost((int) $_POST['id']);
                    $messages['success'] = "Blog deleted successfully!";
                }


                // Redirect to section with messages passed in the data array
                header('Location: index.php?action=dashboard&section=' . $section . '&messages=' . urlencode(serialize($messages)));
                exit;
            } catch (Exception $e) {
                $messages['error'] = "Error: " . $e->getMessage();
                header('Location: index.php?action=dashboard&section=' . $section . '&messages=' . urlencode(serialize($messages)));
                exit;
            }
        }
    }

    public function singlePost($postId)
    {
        // Fetch the blog post by ID
        $post = $this->blogModel->getPostById($postId);

        // Fetch the author name and publish date
        $author = $this->blogModel->getAuthorByPostId($postId);

        // Fetch the comments for the post
        $comments = $this->blogModel->getCommentsByPostId($postId);

        // Pass data to the view
        $blogContent = $this->renderView('singlePost', [
            'post' => $post,
            'author' => $author,
            'comments' => $comments,
        ]);

        echo $this->renderView('layout/app', [
            'content' => $blogContent, // Inject dynamic content
            'pageTitle' => 'Blogs',    // Page-specific title
        ]);
    }


    public function addComment($postId)
    {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentContent = trim($_POST['comment']);

            // Sanitize the input
            $commentContent = htmlspecialchars($commentContent, ENT_QUOTES, 'UTF-8');

            // Validate the comment content
            if (empty($commentContent)) {
                $_SESSION['error'] = 'Comment cannot be empty.';
                header("Location: index.php?action=singlePost&post_id=$postId");
                exit;
            }

            // Add the comment to the database
            try {
                $this->blogModel->addComment($postId, $_SESSION['user']['id'], $commentContent);
                $_SESSION['success'] = 'Comment added successfully!';
            } catch (Exception $e) {
                $_SESSION['error'] = 'There was an error adding your comment.';
            }

            header("Location: index.php?action=singlePost&post_id=$postId");
            exit;
        }
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