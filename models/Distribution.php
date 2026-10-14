<?php
// models/Distribution.php

class Distribution {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getSettings() {
        return $this->db->query("SELECT * FROM distribution_settings LIMIT 1")->fetch();
    }

    public function updateSettings($startup, $member, $execution) {
        if (($startup + $member + $execution) !== 100) {
            return false;
        }
        $stmt = $this->db->prepare("UPDATE distribution_settings SET startup_pct = ?, member_pct = ?, execution_pct = ? WHERE id = 1");
        return $stmt->execute([$startup, $member, $execution]);
    }

    public function getAggregatedTransactions() {
        return $this->db->query("SELECT 
                                    SUM(startup_amount) as total_startup, 
                                    SUM(member_amount) as total_member, 
                                    SUM(execution_amount) as total_execution 
                                 FROM transactions")->fetch();
    }
}
