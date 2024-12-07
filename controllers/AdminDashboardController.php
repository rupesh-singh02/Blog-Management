<?php
require_once '../models/User.php';
require_once '../models/Blog.php';
require_once '../config/database.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AdminDashboardController
{
    private $userModel;
    private $blogModel;
    private $emailConfigModel;
    private $emailTemplateModel;


    public function __construct()
    {
        // Initialize models with a database connection
        $dbConnection = getDBConnection();
        $this->userModel = new User();
        $this->blogModel = new Blog($dbConnection);
        $this->emailConfigModel = new EmailConfig();
        $this->emailTemplateModel = new EmailTemplate();
    }

    // Show the admin dashboard
    public function adminDashboard($section = 'users')
    {
        $data = [];
        $pageTitle = 'Admin Dashboard';

        // Handle different sections
        if ($section === 'users') {
            $data['users'] = $this->userModel->getAllUsers();
            if (isset($_GET['user_id'])) {
                $userId = $_GET['user_id'];
                $user = $this->userModel->getUserById($userId); // Get the specific user data from the database
                $data['user'] = $user; // Pass the user data to the view for population in the form
            }

        } elseif ($section === 'blogs') {
            $data['blogs'] = $this->blogModel->getAllPosts(1000, 0); 
            $data['categories'] = $this->blogModel->getCategories();
            $data['users'] = $this->userModel->getAllUsers();
            if (isset($_GET['blog_id'])) {
                $data['blog'] = $this->blogModel->getPostById($_GET['blog_id']);
            }
            
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
    public function handleAction($task, $type)
    {
        $messages = [];  // Initialize an array to store messages

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $formErrors = [];
                if ($type === 'user') {
                    if ($task === 'add') {
                        $username = trim($_POST['username']);
                        $email = trim($_POST['email']);
                        $password = trim($_POST['password']);
    
                        // Validate input
                        if (empty($username))
                            $formErrors['username'] = 'Username is required.';
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                            $formErrors['email'] = 'Invalid email format.';
                        if (strlen($password) < 6)
                            $formErrors['password'] = 'Password must be at least 6 characters.';
    
                        // Check if user already exists
                        if ($this->userModel->checkIfUserExists($username, $email)) {
                            $formErrors['username'] = 'Username or email already in use.';
                        }
    
    
                        if (!empty($formErrors)) {
                            $messages['error'] = "Validation failed. Please check the form.";
                            $messages['formErrors'] = $formErrors;
                        } else {
                            // Save user
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            $user = $this->userModel->register($username, $email, $hashedPassword);
    
                            if ($user) {
                                $messages['success'] = "User '$username' added successfully!";
                            } else {
                                $messages['error'] = "Failed to add user.";
                            }
                        }
                    } elseif ($task === 'update') {
                        $this->userModel->updateUser([
                            'id' => $_POST['id'],
                            'username' => $_POST['username'],
                            'email' => $_POST['email'],
                        ]);
                        $messages['success'] = "User updated successfully!";
                    } elseif ($task === 'delete') {
                        $this->userModel->deleteUser((int) $_POST['id']);
                        $messages['success'] = "User deleted successfully!";
                    }
                } elseif ($type === 'blog') {
                    if ($task === 'add') {
                        $this->blogModel->addPost(
                            $_POST['title'],
                            $_POST['content'],
                            (int) $_POST['user_id'],
                            (int) $_POST['category']
                        );
                        $messages['success'] = "Blog added successfully!";
                    } elseif ($task === 'update') {
                        $this->blogModel->updatePost(
                            (int) $_POST['id'],
                            $_POST['title'],
                            $_POST['content'],
                            (int) $_POST['user_id'],
                            (int) $_POST['category']
                        );
                        $messages['success'] = "Blog updated successfully!";
                    } elseif ($task === 'delete') {
                        $this->blogModel->deletePost((int) $_POST['id']);
                        $messages['success'] = "Blog deleted successfully!";
                    }
                }

                // Redirect to section with messages passed in the data array
                header('Location: index.php?action=adminDashboard&section=' . $type . 's&messages=' . urlencode(serialize($messages)));
                exit;
            } catch (Exception $e) {
                $messages['error'] = "Error: " . $e->getMessage();
                header('Location: index.php?action=adminDashboard&section=' . $type . 's&messages=' . urlencode(serialize($messages)));
                exit;
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

    public function sendSuccessEmail($email, $username, $password)
    {
        $mail = new PHPMailer(true);

        try {
            // Fetch SMTP configuration
            $emailConfig = $this->emailConfigModel->getConfig();

            // Fetch email template
            $emailTemplate = $this->emailTemplateModel->getTemplate('welcome');

            if (!$emailConfig || !$emailTemplate) {
                throw new Exception("Email configuration or template not found in database.");
            }

            // Replace placeholders in the template
            $emailBody = str_replace(
                ['{username}', '{password}'],
                [$username, $password],
                $emailTemplate['body']
            );

            // Configure PHPMailer
            $mail->isSMTP();
            $mail->Host = $emailConfig['smtp_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $emailConfig['smtp_username'];
            $mail->Password = $emailConfig['smtp_password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $emailConfig['smtp_port'];

            // Set email sender and recipient
            $mail->setFrom($emailConfig['sender_email'], $emailConfig['sender_name']);
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $emailTemplate['subject'];
            $mail->Body = $emailBody;

            // Send email
            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
