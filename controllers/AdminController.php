<?php
// controllers/AdminController.php

class AdminController {
    private $userModel;
    private $incomeModel;
    private $distributionModel;
    private $supportModel;

    public function __construct() {
        if (!is_admin()) redirect(url('Admin/login.php'));
        $this->userModel = new User();
        $this->incomeModel = new Income();
        $this->distributionModel = new Distribution();
        $this->supportModel = new SupportRequest();
    }

    public function dashboard() {
        $stats = [
            'total_income' => $this->incomeModel->getTotalIncome(),
            'daily_total' => $this->incomeModel->getDailyTotal(),
            'monthly_total' => $this->incomeModel->getMonthlyTotal(),
            'yearly_total' => $this->incomeModel->getYearlyTotal(),
            'user_count' => $this->userModel->count(),
            'pending_requests' => $this->supportModel->getPendingCount(),
            'monthly_stats' => $this->incomeModel->getMonthlyStats(),
            'distribution' => $this->distributionModel->getAggregatedTransactions()
        ];
        require_once ROOT_PATH . '/views/admin/dashboard.php';
    }

    public function users() {
        $action = $_GET['action'] ?? 'list';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) die("CSRF validation failed");

            if ($action === 'add') {
                $this->userModel->create($_POST);
                redirect(url('Admin/users.php?success=User added'));
            } elseif ($action === 'edit') {
                $this->userModel->update($_POST['id'], $_POST);
                redirect(url('Admin/users.php?success=User updated'));
            } elseif ($action === 'delete') {
                $this->userModel->delete($_POST['id']);
                redirect(url('Admin/users.php?success=User deleted'));
            }
        }

        $users = $this->userModel->getAll();
        require_once ROOT_PATH . '/views/admin/users.php';
    }

    public function income() {
        $action = $_GET['action'] ?? 'list';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) die("CSRF validation failed");

            if ($action === 'edit') {
                $this->incomeModel->update($_POST['id'], $_POST);
                
                // Notify User
                $entry = $this->incomeModel->getById($_POST['id']);
                if ($entry && $entry['user_id']) {
                    (new Notification())->create(
                        $entry['user_id'], 
                        "Income Protocol Update", 
                        "An administrator has modified your income entry for '" . $entry['source'] . "'.", 
                        "info",
                        "User/history.php"
                    );
                }
                
                redirect(url('Admin/income.php?success=Income updated'));
            } elseif ($action === 'delete') {
                $entry = $this->incomeModel->getById($_POST['id']);
                if ($entry && $entry['user_id']) {
                    (new Notification())->create(
                        $entry['user_id'], 
                        "Income Record Removed", 
                        "Your income entry for '" . $entry['source'] . "' has been removed from the ledger.", 
                        "danger",
                        "User/history.php"
                    );
                }
                $this->incomeModel->delete($_POST['id']);
                redirect(url('Admin/income.php?success=Income deleted'));
            }
        }

        $incomeList = $this->incomeModel->getAll();
        require_once ROOT_PATH . '/views/admin/income.php';
    }

    public function transactions() {
        $filters = [
            'user_id' => $_GET['user_id'] ?? null,
            'start_date' => $_GET['start_date'] ?? null,
            'end_date' => $_GET['end_date'] ?? null
        ];
        $transactions = $this->incomeModel->getAll($filters);
        $users = $this->userModel->getAll();
        require_once ROOT_PATH . '/views/admin/transactions.php';
    }

    public function settings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) die("CSRF validation failed");
            
            $success = $this->distributionModel->updateSettings(
                (int)$_POST['startup_pct'],
                (int)$_POST['member_pct'],
                (int)$_POST['execution_pct']
            );
            
            if ($success) {
                redirect(url('Admin/settings.php?success=Settings updated'));
            } else {
                $error = "Percentages must sum to 100%";
            }
        }
        $settings = $this->distributionModel->getSettings();
        require_once ROOT_PATH . '/views/admin/settings.php';
    }

    public function requests() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) die("CSRF validation failed");
            $this->supportModel->updateStatus($_POST['id'], $_POST['status'], $_POST['admin_notes']);
            
            // Notify User
            $req = $this->supportModel->getById($_POST['id']);
            if ($req) {
                (new Notification())->create(
                    $req['user_id'], 
                    "Support Inquiry Update", 
                    "Administrator has updated the status of your inquiry #" . $req['id'] . " to '" . $_POST['status'] . "'.", 
                    $_POST['status'] === 'resolved' ? 'success' : 'warning',
                    "User/support.php"
                );
            }
            
            redirect(url('Admin/requests.php?success=Request updated'));
        }
        $requests = $this->supportModel->getAll();
        require_once ROOT_PATH . '/views/admin/requests.php';
    }

    public function manageClientsData() {
        $db = Database::getInstance();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) die("CSRF validation failed");
            $action = $_GET['action'] ?? '';
            if ($action === 'add') {
                $stmt = $db->prepare("INSERT INTO clients_data_buttons (label, url) VALUES (?, ?)");
                $stmt->execute([$_POST['label'], $_POST['url']]);
                redirect(url('Admin/manage-clients-data.php?success=Button added'));
            } elseif ($action === 'delete') {
                $stmt = $db->prepare("DELETE FROM clients_data_buttons WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                redirect(url('Admin/manage-clients-data.php?success=Button removed'));
            }
        }
        $buttons = $db->query("SELECT * FROM clients_data_buttons ORDER BY created_at DESC")->fetchAll();
        require_once ROOT_PATH . '/views/admin/manage_clients_data.php';
    }

    public function manageTutorials() {
        $db = Database::getInstance();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) die("CSRF validation failed");
            $action = $_GET['action'] ?? '';
            if ($action === 'add') {
                $stmt = $db->prepare("INSERT INTO tutorials (title, description, media_type, media_url, content_text) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$_POST['title'], $_POST['description'], $_POST['media_type'], $_POST['media_url'], $_POST['content_text']]);
                redirect(url('Admin/manage-tutorials.php?success=Tutorial added'));
            } elseif ($action === 'delete') {
                $stmt = $db->prepare("DELETE FROM tutorials WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                redirect(url('Admin/manage-tutorials.php?success=Tutorial removed'));
            }
        }
        $tutorials = $db->query("SELECT * FROM tutorials ORDER BY created_at DESC")->fetchAll();
        require_once ROOT_PATH . '/views/admin/manage_tutorials.php';
    }
}
