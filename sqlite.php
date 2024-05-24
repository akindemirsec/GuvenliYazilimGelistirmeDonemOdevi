<?php
class Database {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('sqlite:database.db');
        $this->initialize();
    }

    private function initialize() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            role TEXT NOT NULL
        )");

        $this->pdo->exec("CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            price REAL NOT NULL,
            description TEXT,
            image TEXT
        )");

        // Add sample users with different roles
        $this->pdo->exec("INSERT OR IGNORE INTO users (username, password, role) VALUES
            ('admin', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', 'admin'),
            ('editor', '" . password_hash('editor123', PASSWORD_DEFAULT) . "', 'editor'),
            ('viewer', '" . password_hash('viewer123', PASSWORD_DEFAULT) . "', 'viewer')");
    }

    public function fetchAll($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function query($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }
}
?>
