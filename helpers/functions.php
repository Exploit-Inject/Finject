<?php
// helpers/functions.php

/**
 * Sanitize output for HTML
 */
function e($text) {
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to a specific URL
 */
function redirect($url) {
    header("Location: " . $url);
    exit;
}

/**
 * Start session if not already started
 */
function init_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    init_session();
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is admin
 */
function is_admin() {
    init_session();
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * CSRF Protection: Generate token
 */
function csrf_token() {
    init_session();
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * CSRF Protection: Verify token
 */
function verify_csrf_token($token) {
    init_session();
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Format currency
 */
function format_currency($amount) {
    return '$' . number_format($amount, 2);
}

/**
 * Get base URL
 */
function base_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $dir = str_replace('\\', '/', dirname($script));
    return $protocol . '://' . $host . ($dir === '/' ? '' : $dir) . '/';
}

/**
 * Generate asset URL
 */
function asset($path) {
    return base_url() . ltrim($path, '/');
}

/**
 * Generate application URL
 */
function url($path) {
    return base_url() . ltrim($path, '/');
}
