<?php
// models/Income.php

class Income {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function add($amount, $source, $userId) {
        $this->db->beginTransaction();
        try {
            // 1. Insert income
            $stmt = $this->db->prepare("INSERT INTO income (amount, source, user_id) VALUES (?, ?, ?)");
            $stmt->execute([$amount, $source, $userId]);
            $incomeId = $this->db->lastInsertId();

            // 2. Fetch current distribution settings
            $settings = (new Distribution())->getSettings();

            // 3. Calculate amounts
            $startupAmount = ($amount * $settings['startup_pct']) / 100;
            $memberAmount = ($amount * $settings['member_pct']) / 100;
            $executionAmount = ($amount * $settings['execution_pct']) / 100;

            // 4. Record transaction
            $stmt = $this->db->prepare("INSERT INTO transactions (income_id, startup_amount, member_amount, execution_amount) VALUES (?, ?, ?, ?)");
            $stmt->execute([$incomeId, $startupAmount, $memberAmount, $executionAmount]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getAll($filters = []) {
        $sql = "SELECT i.*, u.name as user_name, t.startup_amount, t.member_amount, t.execution_amount 
                FROM income i 
                LEFT JOIN users u ON i.user_id = u.id 
                LEFT JOIN transactions t ON i.id = t.income_id 
                WHERE 1=1";
        $params = [];

        if (!empty($filters['user_id'])) {
            $sql .= " AND i.user_id = ?";
            $params[] = $filters['user_id'];
        }

        if (!empty($filters['start_date'])) {
            $sql .= " AND i.created_at >= ?";
            $params[] = $filters['start_date'] . ' 00:00:00';
        }

        if (!empty($filters['end_date'])) {
            $sql .= " AND i.created_at <= ?";
            $params[] = $filters['end_date'] . ' 23:59:59';
        }

        $sql .= " ORDER BY i.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM income WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getTotalIncome() {
        return $this->db->query("SELECT SUM(amount) FROM income")->fetchColumn() ?? 0;
    }

    public function getMonthlyStats() {
        return $this->db->query("SELECT MONTHNAME(created_at) as month, SUM(amount) as total 
                                 FROM income 
                                 GROUP BY MONTH(created_at) 
                                 ORDER BY MONTH(created_at) ASC")->fetchAll();
    }

    /**
     * Get specific period totals
     */
    public function getDailyTotal($userId = null) {
        $sql = "SELECT SUM(amount) FROM income WHERE DATE(created_at) = CURDATE()";
        if ($userId) $sql .= " AND user_id = " . (int)$userId;
        return $this->db->query($sql)->fetchColumn() ?? 0;
    }

    public function getMonthlyTotal($userId = null) {
        $sql = "SELECT SUM(amount) FROM income WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        if ($userId) $sql .= " AND user_id = " . (int)$userId;
        return $this->db->query($sql)->fetchColumn() ?? 0;
    }

    public function getYearlyTotal($userId = null) {
        $sql = "SELECT SUM(amount) FROM income WHERE YEAR(created_at) = YEAR(CURDATE())";
        if ($userId) $sql .= " AND user_id = " . (int)$userId;
        return $this->db->query($sql)->fetchColumn() ?? 0;
    }

    public function getDailyStats($days = 7) {
        return $this->db->query("SELECT DATE(created_at) as date, SUM(amount) as total 
                                 FROM income 
                                 WHERE created_at >= DATE_SUB(NOW(), INTERVAL $days DAY) 
                                 GROUP BY DATE(created_at) 
                                 ORDER BY DATE(created_at) ASC")->fetchAll();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM income WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function update($id, $data) {
        $this->db->beginTransaction();
        try {
            // 1. Update income
            $stmt = $this->db->prepare("UPDATE income SET amount = ?, source = ? WHERE id = ?");
            $stmt->execute([$data['amount'], $data['source'], $id]);

            // 2. Recalculate distribution
            $settings = (new Distribution())->getSettings();
            $amount = $data['amount'];
            $startupAmount = ($amount * $settings['startup_pct']) / 100;
            $memberAmount = ($amount * $settings['member_pct']) / 100;
            $executionAmount = ($amount * $settings['execution_pct']) / 100;

            // 3. Update transaction
            $stmt = $this->db->prepare("UPDATE transactions SET startup_amount = ?, member_amount = ?, execution_amount = ? WHERE income_id = ?");
            $stmt->execute([$startupAmount, $memberAmount, $executionAmount, $id]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
