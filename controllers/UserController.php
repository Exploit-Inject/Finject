<?php
// controllers/UserController.php

class UserController {
    private $incomeModel;
    private $supportModel;

    public function __construct() {
        if (!is_logged_in()) redirect(url('User/login.php'));
        $this->incomeModel = new Income();
        $this->supportModel = new SupportRequest();
    }

    public function dashboard() {
        $userId = $_SESSION['user_id'];
        $stats = [
            'total_income' => $this->incomeModel->getTotalIncome(), // Global total for dashboard
            'my_total' => array_sum(array_column($this->incomeModel->getAll(['user_id' => $userId]), 'amount')),
            'daily_total' => $this->incomeModel->getDailyTotal($userId),
            'monthly_total' => $this->incomeModel->getMonthlyTotal($userId),
            'yearly_total' => $this->incomeModel->getYearlyTotal($userId),
            'my_history' => $this->incomeModel->getAll(['user_id' => $userId, 'limit' => 5]),
            'pending_requests' => $this->supportModel->getAll(['user_id' => $userId, 'status' => 'pending'])
        ];
        require_once ROOT_PATH . '/views/user/dashboard.php';
    }

    public function history() {
        $userId = $_SESSION['user_id'];
        $history = $this->incomeModel->getAll(['user_id' => $userId]);
        require_once ROOT_PATH . '/views/user/history.php';
    }

    public function support() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) die("CSRF validation failed");
            $this->supportModel->create($_SESSION['user_id'], $_POST['message']);
            
            // Notify Admins
            (new Notification())->notifyAdmins(
                "New Support Inquiry", 
                "Member " . $_SESSION['name'] . " has submitted a new intelligence request.",
                "warning",
                "Admin/requests.php"
            );
            
            redirect(url('User/support.php?success=Request submitted'));
        }
        $requests = $this->supportModel->getAll(['user_id' => $_SESSION['user_id']]);
        require_once ROOT_PATH . '/views/user/support.php';
    }

    public function clients() {
        require_once ROOT_PATH . '/views/user/clients.php';
    }

    public function tools() {
        $toolModel = new Tool();
        $tools = $toolModel->getAll();
        require_once ROOT_PATH . '/views/user/tools.php';
    }

    public function clientsData() {
        $db = Database::getInstance();
        $buttons = $db->query("SELECT * FROM clients_data_buttons ORDER BY created_at DESC")->fetchAll();
        require_once ROOT_PATH . '/views/user/clients_data.php';
    }

    public function tutorials() {
        $db = Database::getInstance();
        $tutorials = $db->query("SELECT * FROM tutorials ORDER BY created_at DESC")->fetchAll();
        require_once ROOT_PATH . '/views/user/tutorials.php';
    }
}
