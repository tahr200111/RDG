<?php
include 'database.php';

$username = 'admin';
$password = 'adminpass';  // استخدم كلمة مرور قوية هنا
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$db = new SQLite3(DB_FILE);
$stmt = $db->prepare('INSERT INTO users (username, pass, is_admin) VALUES (:username, :pass, 1)');
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':pass', $hashed_password, SQLITE3_TEXT);

try {
    $stmt->execute();
    echo "Admin user added successfully.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
