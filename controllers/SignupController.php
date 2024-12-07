<?php
// Include the necessary files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';  // Composer autoload

// Include the database connection and User model
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../models/EmailConfig.php';
require_once '../models/EmailTemplate.php';

class SignupController
{
    private $emailConfigModel;
    private $emailTemplateModel;

    public function __construct()
    {
        $this->emailConfigModel = new EmailConfig();
        $this->emailTemplateModel = new EmailTemplate();
    }

    // Handle signup form submission
    public function signup()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Create a new User instance and try to register the user
            $userModel = new User();
            $user = $userModel->register($username, $email, $hashedPassword);

            if ($user) {
                // If user registered successfully, send email with login details
                $this->sendSuccessEmail($email, $username, $password);

                // Pass success message to the view
                $successMessage = "Signup successful! Please check your email for login credentials.";
                include '../views/login.php';  // Show the login form with success modal
            } else {
                // Show error if registration failed (e.g., user already exists)
                $signupError = "User already exists. Please choose a different username or email.";
                include '../views/login.php';  // Show signup form with error
            }
        }
    }

    // Function to send a success email with login credentials
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
?>