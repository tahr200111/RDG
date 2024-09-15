<?php
// استخدام SQLite لإنشاء قاعدة البيانات
define('DB_FILE', 'users.db');

function createTables() {
    $db = new SQLite3(DB_FILE);

    $db->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        name TEXT DEFAULT NULL,
        pass TEXT NOT NULL,
        is_admin INTEGER DEFAULT 0
    );
    ");

    $db->exec("
    CREATE TABLE IF NOT EXISTS api_keys (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        api_key TEXT NOT NULL UNIQUE,
        user_id INTEGER,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
    ");

    $db->close();
    echo "Database and tables created in " . DB_FILE;
}

createTables();
?>
