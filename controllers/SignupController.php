<?php
// Include the necessary files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';  // Composer autoload

// Include the database connection and User model
require_once '../config/database.php';
require_once '../models/User.php';

class SignupController {

    // Handle signup form submission
    public function signup() {
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
                $error = "User already exists. Please choose a different username or email.";
                include '../views/login.php';  // Show signup form with error
            }
        }
    }

    // Function to send a success email with login credentials
    private function sendSuccessEmail($email, $username, $password) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Set the SMTP server (use your SMTP provider)
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com';  // SMTP username
            $mail->Password = 'your_email_password';  // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('your_email@gmail.com', 'Your Name');
            $mail->addAddress($email);  // Add the recipient's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Signup Credentials';
            $mail->Body    = "Hi $username,<br><br>You have successfully signed up.<br>Your login credentials are:<br>Username: $username<br>Password: $password<br><br>Thanks for joining us!";

            // Send the email
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>
