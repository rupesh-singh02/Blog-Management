<?php

require_once '../config/database.php';

class EmailConfig {
    private $db;

    public function __construct() {
        $this->db = getDBConnection();
    }

    // Fetch email configuration
    public function getConfig() {
        $query = $this->db->query("SELECT * FROM email_config LIMIT 1");
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
