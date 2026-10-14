<?php
// Secret/fix_db_migration.php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/config/database.php';

$db = Database::getInstance();

try {
    // Check if 'type' column exists in 'notifications'
    $stmt = $db->query("SHOW COLUMNS FROM notifications LIKE 'type'");
    $exists = $stmt->fetch();

    if (!$exists) {
        $db->exec("ALTER TABLE notifications ADD COLUMN type VARCHAR(50) DEFAULT 'info' AFTER message");
        echo "<h1>Migration: SUCCESS</h1>";
        echo "<p>Intelligence Protocol Updated: The 'type' column has been successfully added to the notifications table.</p>";
    } else {
        echo "<h1>Migration: ABORTED</h1>";
        echo "<p>The database protocol is already up to date.</p>";
    }
} catch (Exception $e) {
    echo "<h1>Migration: FAILED</h1>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
