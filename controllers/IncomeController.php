<?php
// controllers/IncomeController.php

class IncomeController {
    private $incomeModel;

    public function __construct() {
        if (!is_logged_in()) redirect(url('User/login.php'));
        $this->incomeModel = new Income();
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) die("CSRF validation failed");

            $amount = (float)$_POST['amount'];
            $source = $_POST['source'];
            $userId = $_SESSION['user_id'];

            if ($this->incomeModel->add($amount, $source, $userId)) {
                // Notify Admins
                $notif = new Notification();
                $notif->notifyAdmins(
                    "New Income Protocol", 
                    "Member " . $_SESSION['name'] . " registered " . format_currency($amount) . " from $source.",
                    "success",
                    "Admin/transactions.php" // Direct link to audit logs
                );
                
                $redirectPath = is_admin() ? 'Admin/income.php' : 'User/history.php';
                redirect(url($redirectPath . '?success=Income added and distributed'));
            } else {
                $error = "Failed to add income. Please try again.";
            }
        }
        
        // If not a POST request, redirect back to dashboard
        $redirectPath = is_admin() ? 'Admin/dashboard.php' : 'User/dashboard.php';
        redirect(url($redirectPath));
    }
}
