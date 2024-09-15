<?php
session_start();
include 'database.php';

function get_user_name($user_id) {
    $db = new SQLite3(DB_FILE);
    $stmt = $db->prepare('SELECT name FROM users WHERE id = :id');
    $stmt->bindValue(':id', $user_id, SQLITE3_INTEGER);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    return $result ? $result['name'] : 'Guest';
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_name = get_user_name($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - RDG</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: #f5f5f5;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
        }
        h1 {
            font-size: 3em;
            color: #e74c3c;
        }
        p {
            font-size: 1.2em;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            background-color: #e74c3c;
            color: #fff;
            font-size: 1.2em;
            text-decoration: none;
        }
        .button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
        <p>This is the main page of RDG.</p>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <a href="admin.php" class="button">Admin Panel</a>
        <?php endif; ?>
        <a href="logout.php" class="button">Logout</a>
    </div>
</body>
</html>
