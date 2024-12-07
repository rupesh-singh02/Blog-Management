<?php
require_once '../config/database.php'; // Include database connection

function insertForgotPasswordTemplate() {
    try {
        // Get database connection
        $db = getDBConnection();

        // Define the email template
        $templateName = "forgot_password";
        $subject = "Password Reset Request";
        $body = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #6c63ff;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            color: #333333;
        }
        .email-body h2 {
            color: #6c63ff;
            font-size: 20px;
            margin-top: 0;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.6;
        }
        .email-body .reset-link {
            background-color: #6c63ff;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: inline-block;
            border-radius: 5px;
            margin-top: 20px;
        }
        .email-body .reset-link:hover {
            background-color: #574bff;
        }
        .email-footer {
            background-color: #f4f4f4;
            color: #777777;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }
        .email-footer a {
            color: #6c63ff;
            text-decoration: none;
        }
        .email-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="email-body">
            <h2>Hi {username},</h2>
            <p>We received a request to reset your password. If this was you, click the button below to reset your password:</p>
            <a href="{reset_link}" class="reset-link">Reset Password</a>
            <p>If you didn’t request this, you can safely ignore this email.</p>
            <p>If you have any questions, feel free to reach out to our support team at <a href="mailto:blog@rupeshsingh.in">blog@rupeshsingh.in</a>.</p>
        </div>
        <div class="email-footer">
            <p>© Let's Blog. All rights reserved.</p>
            <p>
                <a href="https://blog.rupeshsingh.in">Visit our website</a> |
                <a href="mailto:blog@rupeshsingh.in">Contact support</a>
            </p>
        </div>
    </div>
</body>
</html>
HTML;

        // Insert the template into the database
        $sql = "INSERT INTO email_templates (template_name, subject, body) VALUES (:template_name, :subject, :body)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':template_name', $templateName);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':body', $body, PDO::PARAM_LOB);

        if ($stmt->execute()) {
            echo "Forgot Password email template inserted successfully!<br>";
        } else {
            echo "Failed to insert Forgot Password email template.<br>";
        }
    } catch (PDOException $e) {
        die("Error inserting Forgot Password email template: " . $e->getMessage());
    }
}
