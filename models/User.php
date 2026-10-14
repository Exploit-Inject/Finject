<?php
// models/User.php

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (name, full_name, email, whatsapp_number, phone_number, personal_email, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['full_name'] ?? $data['name'],
            $data['email'],
            $data['whatsapp_number'] ?? null,
            $data['phone_number'] ?? null,
            $data['personal_email'] ?? null,
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET name = ?, full_name = ?, email = ?, whatsapp_number = ?, phone_number = ?, personal_email = ?, role = ?";
        $params = [
            $data['name'], 
            $data['full_name'], 
            $data['email'], 
            $data['whatsapp_number'], 
            $data['phone_number'], 
            $data['personal_email'], 
            $data['role']
        ];
        
        if (!empty($data['password'])) {
            $sql .= ", password = ?";
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function count() {
        return $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }
}
