<?php
// controllers/AuthController.php

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) {
                die("CSRF token validation failed.");
            }

            $email = $_POST['email'];
            $password = $_POST['password'];
            $type = $_GET['type'] ?? 'user';

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Check role restriction
                if ($type === 'admin' && $user['role'] !== 'admin') {
                    $error = "Access denied. Admin only.";
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['name'] = $user['name'];
                    session_regenerate_id(true);

                    if ($user['role'] === 'admin') {
                        redirect(url('Admin/dashboard.php'));
                    } else {
                        redirect(url('User/dashboard.php'));
                    }
                }
            } else {
                $error = "Invalid email or password.";
            }
        }

        require_once ROOT_PATH . '/views/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'])) {
                die("CSRF token validation failed.");
            }

            // Simple validation
            if ($_POST['password'] !== $_POST['confirm_password']) {
                $error = "Passwords do not match.";
            } elseif ($this->userModel->findByEmail($_POST['email'])) {
                $error = "Email already registered.";
            } else {
                $_POST['role'] = 'lead_hunter'; // Default role for new signups
                if ($this->userModel->create($_POST)) {
                    redirect(url('User/login.php?success=Account created. Please login.'));
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }
        }

        require_once ROOT_PATH . '/views/register.php';
    }

    public function logout() {
        session_destroy();
        redirect(url('index.php'));
    }
}
