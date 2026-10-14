<?php
// models/Notification.php

class Notification {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Create a new notification
     */
    public function create($userId, $title, $message, $type = 'info', $link = null) {
        $stmt = $this->db->prepare("INSERT INTO notifications (user_id, title, message, type, link) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $title, $message, $type, $link]);
    }

    /**
     * Notify all admins
     */
    public function notifyAdmins($title, $message, $type = 'info', $link = null) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE role = 'admin'");
        $stmt->execute();
        $admins = $stmt->fetchAll();
        
        foreach ($admins as $admin) {
            $this->create($admin['id'], $title, $message, $type, $link);
        }
        return true;
    }

    /**
     * Get unread notifications for a user
     */
    public function getUnread($userId, $limit = 10) {
        $limit = (int)$limit;
        $stmt = $this->db->prepare("SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC LIMIT $limit");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * Get all notifications for a user (History)
     */
    public function getAll($userId, $limit = 50) {
        $limit = (int)$limit;
        $stmt = $this->db->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT $limit");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * Get unread count
     */
    public function getUnreadCount($userId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($id, $userId) {
        $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllRead($userId) {
        $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
}
