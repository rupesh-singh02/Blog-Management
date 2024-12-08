<?php
class Blog
{
    private $db;

    // Constructor accepts a database connection
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Get all categories
    public function getCategories()
    {
        $stmt = $this->db->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all posts
    public function getAllPosts($limit, $offset)
    {
        $query = "
        SELECT blog_posts.*, 
               categories.name AS category_name, 
               users.username AS author_name 
        FROM blog_posts
        JOIN categories ON blog_posts.category_id = categories.id
        JOIN users ON blog_posts.author_id = users.id
        LIMIT :limit OFFSET :offset
    ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPostsByCategory($categoryId, $limit, $offset)
    {
        $stmt = $this->db->prepare("
        SELECT blog_posts.*, 
               categories.name AS category_name, 
               users.username AS author_name 
        FROM blog_posts
        JOIN categories ON blog_posts.category_id = categories.id
        JOIN users ON blog_posts.author_id = users.id
        WHERE category_id = :category_id 
        ORDER BY published_at DESC
        LIMIT :limit OFFSET :offset
    ");
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Add a new blog post
    public function addPost($title, $content, $authorId, $categoryId)
    {
        $query = "INSERT INTO blog_posts (title, content, author_id, category_id) VALUES (:title, :content, :author_id, :category_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        return $stmt->execute(); // Return true if insertion is successful
    }

    // Update an existing blog post
    public function updatePost($id, $title, $content, $authorId, $categoryId)
    {
        $query = "UPDATE blog_posts SET title = :title, content = :content, author_id = :author_id, category_id = :category_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        return $stmt->execute(); // Return true if update is successful
    }

    // Delete a blog post
    public function deletePost($id)
    {
        $query = "DELETE FROM blog_posts WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute(); // Return true if deletion is successful
    }

    // Get a single blog post by ID
    public function getPostById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM blog_posts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all blog posts by a specific user
    public function getPostsByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT blog_posts.*, 
                                       categories.name AS category_name, 
                                       users.username AS author_name 
                                FROM blog_posts
                                JOIN categories ON blog_posts.category_id = categories.id
                                JOIN users ON blog_posts.author_id = users.id
                                WHERE blog_posts.author_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all posts for the given user
    }

    public function getAuthorByPostId($postId)
    {
        // Query to fetch the author's name
        $stmt = $this->db->prepare("SELECT * FROM users u JOIN blog_posts p ON u.id = p.author_id WHERE p.id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetch();
    }

    public function getCommentsByPostId($postId)
    {
        // Query to fetch comments along with the user's name
        $stmt = $this->db->prepare("
            SELECT comments.*, users.username AS username 
            FROM comments 
            JOIN users ON comments.user_id = users.id 
            WHERE comments.post_id = ? 
            ORDER BY comments.created_at DESC
        ");
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }


    public function addComment($postId, $userId, $commentContent)
    {
        // Query to insert a new comment into the database
        $stmt = $this->db->prepare("INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$postId, $userId, $commentContent]);
    }

    public function getRecentPosts()
    {
        $stmt = $this->db->prepare("
            SELECT blog_posts.*, 
                   categories.name AS category_name, 
                   users.username AS author_name 
            FROM blog_posts
            JOIN categories ON blog_posts.category_id = categories.id
            JOIN users ON blog_posts.author_id = users.id
            ORDER BY blog_posts.created_at DESC
            LIMIT 5
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get top 5 blogs with the highest number of comments
    public function getTopCommentedPosts()
    {
        $stmt = $this->db->prepare("
            SELECT blog_posts.*, 
                   categories.name AS category_name, 
                   users.username AS author_name, 
                   COUNT(comments.id) AS comment_count
            FROM blog_posts
            LEFT JOIN comments ON blog_posts.id = comments.post_id
            JOIN categories ON blog_posts.category_id = categories.id
            JOIN users ON blog_posts.author_id = users.id
            GROUP BY blog_posts.id
            ORDER BY comment_count DESC, blog_posts.created_at DESC
            LIMIT 5
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>