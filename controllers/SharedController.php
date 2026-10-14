<?php
// controllers/SharedController.php

class SharedController {
    public function poll() {
        if (!is_logged_in()) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $db = Database::getInstance();
        $notifModel = new Notification();
        $incomeModel = new Income();
        $supportModel = new SupportRequest();

        $data = [
            'notifications' => [
                'unread_count' => $notifModel->getUnreadCount($userId),
                'recent' => $notifModel->getUnread($userId, 5)
            ],
            'stats' => is_admin() ? [
                'total_income' => $incomeModel->getTotalIncome(),
                'daily_total' => $incomeModel->getDailyTotal(),
                'pending_requests' => $supportModel->getPendingCount(),
                'last_request_id' => $db->query("SELECT MAX(id) FROM support_requests")->fetchColumn()
            ] : [
                'my_total' => array_sum(array_column($incomeModel->getAll(['user_id' => $userId]), 'amount')),
                'daily_total' => $incomeModel->getDailyTotal($userId),
                'support_fingerprint' => md5(json_encode($supportModel->getAll(['user_id' => $userId])))
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function markAllRead() {
        if (!is_logged_in()) return;
        $notifModel = new Notification();
        $notifModel->markAllRead($_SESSION['user_id']);
        echo json_encode(['success' => true]);
    }
}
