<?php
// models/Tool.php

class Tool {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM tools ORDER BY name ASC")->fetchAll();
    }
}
