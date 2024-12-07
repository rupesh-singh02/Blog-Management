<?php
require_once '../config/database.php'; // Include database connection

function insertEmailTemplate() {
    try {
        // Get database connection
        $db = getDBConnection();

        // Define the email template
        $templateName = "welcome";
        $subject = "Welcome to Let's Blog";
        $body = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
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
        .email-body .credentials {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
            margin: 20px 0;
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
            <h1>Welcome to Let's Blog</h1>
        </div>
        <div class="email-body">
            <h2>Hi {username},</h2>
            <p>We are thrilled to have you on board! Thank you for signing up with us.</p>
            <div class="credentials">
                <p><strong>Username:</strong> {username}</p>
                <p><strong>Password:</strong> {password}</p>
            </div>
            <p>We hope you enjoy our services!</p>
        </div>
        <div class="email-footer">
            <p>© Let's Blog. All rights reserved.</p>
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
            echo "Email template inserted successfully!<br>";
        } else {
            echo "Failed to insert email template.<br>";
        }
    } catch (PDOException $e) {
        die("Error inserting email template: " . $e->getMessage());
    }
}
