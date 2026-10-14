<?php
// index.php (Root Entry Point)

// Error reporting (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Root path
define('ROOT_PATH', __DIR__);

// Require core files
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/helpers/functions.php';

// Autoloader for Models and Controllers
spl_autoload_register(function ($class) {
    if (file_exists(ROOT_PATH . '/models/' . $class . '.php')) {
        require_once ROOT_PATH . '/models/' . $class . '.php';
    } elseif (file_exists(ROOT_PATH . '/controllers/' . $class . '.php')) {
        require_once ROOT_PATH . '/controllers/' . $class . '.php';
    }
});

init_session();

// Simple Router
$route = $_GET['route'] ?? 'home';

// Basic Access Control Middleware
$protected_routes = [
    'admin' => ['admin/dashboard', 'admin/users', 'admin/income', 'admin/transactions', 'admin/settings', 'admin/requests'],
    'user' => ['user/dashboard', 'user/history', 'user/support', 'user/add-income']
];

// Determine if the route is protected
$is_admin_route = false;
$is_user_route = false;

foreach ($protected_routes['admin'] as $r) {
    if (strpos($route, $r) === 0) {
        $is_admin_route = true;
        break;
    }
}

foreach ($protected_routes['user'] as $r) {
    if (strpos($route, $r) === 0) {
        $is_user_route = true;
        break;
    }
}

// Redirect logic
if ($is_admin_route && !is_admin()) {
    redirect(url('Admin/login.php'));
}

if ($is_user_route && !is_logged_in()) {
    redirect(url('User/login.php'));
}

// Route Handling
switch ($route) {
    case 'admin_root':
        if (is_admin()) {
            redirect(url('Admin/dashboard.php'));
        } elseif (is_logged_in()) {
            redirect(url('User/dashboard.php'));
        } else {
            redirect(url('Admin/login.php'));
        }
        break;

    case 'user_root':
        if (is_logged_in()) {
            redirect(url('User/dashboard.php'));
        } else {
            redirect(url('User/login.php'));
        }
        break;

    case 'home':
        require_once ROOT_PATH . '/views/home.php';
        break;
    
    case 'login':
        $auth = new AuthController();
        $auth->login();
        break;

    case 'register':
        $auth = new AuthController();
        $auth->register();
        break;

    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;

    // Admin Routes
    case 'admin/dashboard':
        $admin = new AdminController();
        $admin->dashboard();
        break;
    
    case 'admin/users':
        $admin = new AdminController();
        $admin->users();
        break;

    case 'admin/income':
        $admin = new AdminController();
        $admin->income();
        break;

    case 'admin/transactions':
        $admin = new AdminController();
        $admin->transactions();
        break;

    case 'admin/settings':
        $admin = new AdminController();
        $admin->settings();
        break;

    case 'admin/requests':
        $admin = new AdminController();
        $admin->requests();
        break;

    case 'admin/manage-clients-data':
        $admin = new AdminController();
        $admin->manageClientsData();
        break;

    case 'admin/manage-tutorials':
        $admin = new AdminController();
        $admin->manageTutorials();
        break;

    // User Routes
    case 'user/dashboard':
        $user = new UserController();
        $user->dashboard();
        break;

    case 'user/history':
        $user = new UserController();
        $user->history();
        break;

    case 'user/support':
        $user = new UserController();
        $user->support();
        break;

    case 'user/clients':
        $user = new UserController();
        $user->clients();
        break;

    case 'user/tools':
        $user = new UserController();
        $user->tools();
        break;

    case 'user/clients-data':
        $user = new UserController();
        $user->clientsData();
        break;

    case 'user/tutorials':
        $user = new UserController();
        $user->tutorials();
        break;

    case 'user/add-income':
        $income = new IncomeController();
        $income->add();
        break;

    // Shared Routes
    case 'shared/notifications':
        if (!is_logged_in()) redirect(url('User/login.php'));
        $notif = new Notification();
        if (isset($_GET['action']) && $_GET['action'] === 'markRead' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $notif->markAllRead($_SESSION['user_id']);
            exit;
        }
        $notifications = $notif->getAll($_SESSION['user_id']);
        require_once ROOT_PATH . '/views/shared/notifications.php';
        break;

    case 'shared/poll':
        $shared = new SharedController();
        $shared->poll();
        break;

    case 'shared/mark-all-read':
        $shared = new SharedController();
        $shared->markAllRead();
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
