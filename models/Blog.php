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
        $query = "SELECT * FROM blog_posts LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get posts by category
    public function getPostsByCategory($categoryId, $limit, $offset)
    {
        $stmt = $this->db->prepare("SELECT * FROM blog_posts WHERE category_id = :category_id ORDER BY published_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new blog post
    public function addPost($title, $content, $categoryId, $publishedAt)
    {
        $query = "INSERT INTO blog_posts (title, content, category_id, published_at) VALUES (:title, :content, :category_id, :published_at)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':published_at', $publishedAt);
        return $stmt->execute(); // Return true if insertion is successful
    }

    // Update an existing blog post
    public function updatePost($id, $title, $content, $categoryId, $publishedAt)
    {
        $query = "UPDATE blog_posts SET title = :title, content = :content, category_id = :category_id, published_at = :published_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':published_at', $publishedAt);
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
}
?>
