# Blog Management

Blog Management is a web application that allows users to create, manage, and publish blog posts. It supports user authentication, categorization of posts, and admin privileges for managing users and content.

## Features

- User registration and login
- Forgot password functionality
- Role-based access control (admin, user)
- Manage blog posts (create, read, update, delete)
- Manage categories for blog posts
- Commenting on blog posts
- Email notifications for registration and password reset
- Admin dashboard for managing users and posts

## Prerequisites

Before you start, ensure you have the following installed on your machine:

- [PHP](https://www.php.net/downloads) 
- [MySQL](https://www.mysql.com/downloads/)
- [Composer](https://getcomposer.org/) for managing PHP dependencies

## Installation

Follow these steps to set up the project locally:

### 1. Clone the repository

```bash
git clone https://github.com/rupesh-singh02/Blog-Management.git
cd Blog-Management


### 2. Install dependencies
composer install


### 3. Set Up the Database
Open your browser and navigate to http://localhost/blog-management/public/setup.php

This will:
    - Create the database and necessary tables.
    - Insert an admin user with the username admin and password admin123.
    - Insert 5 sample categories.


### 4. Create a New User

Open your browser and navigate to http://localhost/blog-management/public/index.php?action=login


## Usage

1. User Registration:

Users can sign up by providing their username, email, and password.

2. Login:

Users can log in with their credentials.

3. Create and Manage Posts:

Logged-in users can create, view, and manage blog posts.

4. Admin Features:

Admins can manage users, blog posts, and categories from the dashboard.

5. Password Reset:

Users can reset their password by providing their email address.
