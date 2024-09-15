<?php
session_start();
include 'database.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $db = new SQLite3(DB_FILE);
    $stmt = $db->prepare('INSERT INTO users (username, pass, is_admin) VALUES (:username, :pass, 1)');
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':pass', $hashed_password, SQLITE3_TEXT);

    try {
        $stmt->execute();
        $success = "Admin user added successfully.";
    } catch (Exception $e) {
        $error = "Username already exists.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - RDG</title>
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
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #222;
            color: #f5f5f5;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
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
        .message {
            color: #e74c3c;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Panel</h1>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Admin Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="button">Add Admin</button>
        </form>
        <?php if (isset($success)): ?>
            <p class="message"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <a href="index.php" class="button">Back to Home</a>
    </div>
</body>
</html>
