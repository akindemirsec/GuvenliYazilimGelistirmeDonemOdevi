<?php

class Database {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('sqlite:database.db');
        $this->initialize();
    }

    private function initialize() {
        // Kullanıcılar tablosunu oluştur
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            profile_image TEXT,
            role TEXT NOT NULL DEFAULT 'user'
        )");

        // Ürünler tablosunu oluştur (eğer yoksa)
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            price REAL NOT NULL,
            description TEXT,
            image TEXT
        )");

        // Admin kullanıcısını ekle
        $adminExists = $this->fetch('SELECT * FROM users WHERE username = :username', ['username' => 'admin']);
        if (!$adminExists) {
            $this->query('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)', [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'role' => 'admin'
            ]);
        }

        // Editor kullanıcısını ekle
        $editorExists = $this->fetch('SELECT * FROM users WHERE username = :username', ['username' => 'editor']);
        if (!$editorExists) {
            $this->query('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)', [
                'username' => 'editor',
                'password' => password_hash('editor123', PASSWORD_BCRYPT),
                'role' => 'editor'
            ]);
        }
    }

    public function query($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    public function fetch($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
