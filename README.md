
# Blog Management

Blog Management is a web application that allows users to create, manage, and publish blog posts. It supports user authentication, categorization of posts, and admin privileges for managing users and content.

---

## Features

- **User Registration and Login**: Secure user authentication system.
- **Forgot Password**: Password reset functionality via email.
- **Role-based Access Control**: Admin and user roles for content and user management.
- **Blog Post Management**: Create, read, update, and delete blog posts.
- **Category Management**: Organize blog posts by categories.
- **Commenting**: Users can comment on blog posts.
- **Email Notifications**: Email notifications for user registration and password reset.
- **Admin Dashboard**: Manage users, posts, and categories.

---

## Prerequisites

Ensure you have the following installed before starting:

1. [PHP](https://www.php.net/downloads) (Version 7.4 or higher)
2. [MySQL](https://www.mysql.com/downloads/)
3. [Composer](https://getcomposer.org/) (Dependency manager for PHP)

---

## Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/rupesh-singh02/Blog-Management.git
cd Blog-Management
```

### Step 2: Install Dependencies

Run the following command to install required PHP packages:

```bash
composer install
```

### Step 3: Set Up the Database

1. Open your browser and navigate to:

   ```
   http://localhost/blog-management/public/setup.php
   ```

2. This script will:
   - Create the database and required tables.
   - Insert an admin user with the following credentials:
     - **Username:** `admin`
     - **Password:** `admin123`
   - Add 5 sample categories.

### Step 4: Configure SMTP Settings

Insert SMTP credentials into the `email_config` table for email functionality. Use the following query as an example:

```sql
INSERT INTO `email_config` (`id`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `sender_email`, `sender_name`) 
VALUES 
(1, 'mail.rupeshsingh.in', 587, 'blog@rupeshsingh.in', 'Slayer@123', 'blog@rupeshsingh.in', 'Let\'s Blog');
```

### Step 5: Start the Application

1. Open your browser and navigate to:

   ```
   http://localhost/blog-management/public/index.php?action=login
   ```

2. You can now log in and use the application.

---

## Usage

### 1. User Registration:

Users can register by providing their username, email, and password.

### 2. Login:

Registered users can log in using their credentials.

### 3. Create and Manage Posts:

Users can create, edit, and delete their blog posts.

### 4. Admin Features:

Admins have additional privileges to:
- Manage users.
- Manage blog posts.
- Manage categories.

### 5. Password Reset:

Users can reset their password by entering their registered email address.

---

## Admin Credentials

Use these credentials to log in as an admin:

- **Username:** `admin`
- **Password:** `admin123`

---

## Folder Structure

```
Blog-Management/
│
├── config/               # Database and application configurations
│   ├── database.php      # MySQL connection settings
│   ├── email.php         # Email configuration settings
│
├── controllers/          # PHP controllers for application logic
│   ├── LoginController.php
│   ├── SignupController.php
│   ├── PostController.php
│   ├── AdminController.php
│
├── email_templates/      # HTML email templates
│   ├── welcome.php       # Welcome email template
│   ├── forgotpassword.php# Password reset email template
│
├── models/               # PHP models for database operations
│   ├── User.php          # User-related database operations
│   ├── Post.php          # Blog post-related database operations
│   ├── Category.php      # Category-related database operations
│
├── public/               # Public directory for accessible files
│   ├── index.php         # Main entry point for the application
│   ├── setup.php         # Setup script for initializing the database
│
├── sql/                  # SQL scripts for database schema
│   ├── database_schema.sql
│
├── vendor/               # Composer dependencies
│
└── README.md             # Project documentation
```

---

## Notes

- Make sure to update the SMTP credentials with your own email server details.
- If you're hosting on a server, ensure the `public` folder is set as the document root.
- The `setup.php` script should be run only once to initialize the database.

Enjoy blogging! 🚀
