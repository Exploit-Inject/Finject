<?php
// Secret/fix_admin.php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/config/database.php';

$db = Database::getInstance();
$newPassword = 't@nim.@dmin'; // Default recovery password
$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $db->prepare("UPDATE users SET password = ? WHERE email = 'admin@finject.com'");
if ($stmt->execute([$hashed])) {
    echo "<h1>Protocol Update: SUCCESS</h1>";
    echo "<p>Administrator identity [admin@finject.com] has been reset to default master key.</p>";
} else {
    echo "<h1>Protocol Update: FAILED</h1>";
}
?>
