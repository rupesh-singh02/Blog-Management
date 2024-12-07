<?php

require_once '../config/database.php';

class EmailTemplate {
    private $db;

    public function __construct() {
        $this->db = getDBConnection();
    }

    // Fetch email template by name
    public function getTemplate($templateName) {
        $query = $this->db->prepare("SELECT * FROM email_templates WHERE template_name = :template_name");
        $query->execute(['template_name' => $templateName]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
