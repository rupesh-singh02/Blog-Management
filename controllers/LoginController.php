<?php
require_once '../models/User.php';
require_once '../models/EmailConfig.php';
require_once '../models/EmailTemplate.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginController
{

    private $userModel;

    private $emailConfigModel;
    private $emailTemplateModel;

    public function __construct()
    {
        $this->emailConfigModel = new EmailConfig();
        $this->emailTemplateModel = new EmailTemplate();
        $this->userModel = new User();
    }

    // Show login form
    public function showLoginForm()
    {
        include '../views/login.php';
    }

    // Handle login
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Check credentials using the User model
            $userModel = new User();
            if (!$userModel->checkLogin($username, $password)) {
                    $loginError = "Invalid username or password.";
                    include '../views/login.php';

            } else {
                $user = $userModel->checkLogin($username, $password);

                $_SESSION['user'] = $user;
                    if ($user['role'] === 'admin') {
                        header('Location: index.php?action=adminDashboard');
                    } else {
                        header('Location: index.php?action=dashboard');
                    }
                    exit;
            }
        }
    }

    // Handle logout
    public function logout()
    {
        // Destroy session and redirect to login page
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }

    public function processForgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            // Fetch user by email
            $user = $this->userModel->getUserByEmail($email);

            if (!$user) {
                $resetError = "The email address is not registered.";
                $temp = "error";
                require '../views/login.php';
                return;
            }

            // Generate reset token and expiration time
            $resetToken = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', strtotime('+5 minutes'));

            // Save token to the `reset_password_token` table
            if ($this->userModel->storePasswordResetToken($user['id'], $resetToken, $expiresAt)) {
                // Send the email
                if ($this->sendSuccessEmail($user, $resetToken)) {
                    $resetMessage = "A password reset link has been sent to your email address.";
                    $temp = "success";

                } else {
                    $resetError = "Failed to send the email. Please try again.";
                    $temp = "error";
                }
            } else {
                $resetError = "Failed to generate reset token. Please try again.";
                $temp = "error";
            }

            require '../views/login.php';
        }
    }

    public function resetPasswordForm($token)
    {
        // Validate the token
        if (!$this->userModel->isValidToken($token)) {
            $error = "The reset link is invalid or expired.";
            require '../views/resetPassword.php';
            return;
        }

        require '../views/resetPassword.php';
    }

    public function processResetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
            $newPassword = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            // Validate token
            if (!$this->userModel->isValidToken($token)) {
                $error = "The reset link is invalid or expired.";
                require '../views/resetPassword.php';
                return;
            }

            // Fetch user ID associated with the token
            $userId = $this->userModel->getUserIdByToken($token);

            if (!$userId) {
                $error = "The reset link is invalid or expired.";
                require '../views/resetPassword.php';
                return;
            }

            // Hash the new password and update it
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            if ($this->userModel->updatePassword($userId, $hashedPassword)) {
                // Delete the used token
                $this->userModel->deleteToken($token);

                $successMessage = "Your password has been successfully reset.";
                header('Location: index.php?action=login');
                exit;
            } else {
                $error = "Failed to reset the password. Please try again.";
                require '../views/resetPassword.php';
            }
        }
    }

    public function sendSuccessEmail($user, $resetToken)
    {
        $mail = new PHPMailer(true);

        try {
            // Fetch SMTP configuration
            $emailConfig = $this->emailConfigModel->getConfig();

            // Fetch email template
            $emailTemplate = $this->emailTemplateModel->getTemplate('forgot_password');

            if (!$emailConfig || !$emailTemplate) {
                throw new Exception("Email configuration or template not found in database.");
            }

            // Replace placeholders in the template
            $resetLink = "http://127.0.0.1/blog-management/public/index.php?action=resetPassword&token=" . $resetToken;
            $body = str_replace(
                ['{username}', '{reset_link}'],
                [$user['username'], $resetLink],
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
            $mail->addAddress($user['email']);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $emailTemplate['subject'];
            $mail->Body = $body;

            // Send email
            $mail->send();

            return true;
        } catch (Exception $e) {
            error_log("Error sending email: {$mail->ErrorInfo}");
            return false;
        }
    }

}
?>