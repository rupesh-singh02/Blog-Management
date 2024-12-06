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
        $query = "SELECT * FROM blog_posts LIMIT :limit OFFSET :offset"; // SQL query to fetch all posts
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        // Check if data is fetched
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Posts from DB: " . print_r($posts, true));  // Log data to check if it's returning posts

        return $posts;
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

    // Get posts
    public function getPosts($limit, $offset)
    {
        $stmt = $this->db->prepare("SELECT * FROM blog_posts ORDER BY published_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
