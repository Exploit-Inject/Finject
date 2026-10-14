<?php
// Secret/fix_user.php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/config/database.php';

$db = Database::getInstance();
$newPassword = 't@nim.@dmin'; // Default recovery t@nim.@dmin
$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $db->prepare("UPDATE users SET password = ? WHERE email = 'user@finject.com'");
if ($stmt->execute([$hashed])) {
    echo "<h1>Protocol Update: SUCCESS</h1>";
    echo "<p>Member identity [user@finject.com] has been reset to default security key.</p>";
} else {
    echo "<h1>Protocol Update: FAILED</h1>";
}
?>
