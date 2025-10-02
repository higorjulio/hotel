<?php
require_once __DIR__ . '/../db.php';
class User {
    public static function findByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    public static function create($name, $email, $password, $type) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$name, $email, $password, $type]);
    }
}