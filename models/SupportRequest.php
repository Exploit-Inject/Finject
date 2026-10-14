<?php
// models/SupportRequest.php

class SupportRequest {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($userId, $message) {
        $stmt = $this->db->prepare("INSERT INTO support_requests (user_id, message) VALUES (?, ?)");
        return $stmt->execute([$userId, $message]);
    }

    public function getAll($filters = []) {
        $sql = "SELECT s.*, u.name as user_name, u.email as user_email 
                FROM support_requests s 
                LEFT JOIN users u ON s.user_id = u.id 
                WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND s.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['user_id'])) {
            $sql .= " AND s.user_id = ?";
            $params[] = $filters['user_id'];
        }

        $sql .= " ORDER BY s.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status, $notes = '') {
        $stmt = $this->db->prepare("UPDATE support_requests SET status = ?, admin_notes = ? WHERE id = ?");
        return $stmt->execute([$status, $notes, $id]);
    }

    public function getPendingCount() {
        return $this->db->query("SELECT COUNT(*) FROM support_requests WHERE status = 'pending'")->fetchColumn();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM support_requests WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
