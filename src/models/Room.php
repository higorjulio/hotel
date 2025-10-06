<?php
require_once __DIR__ . '/../db.php';

class Room {
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM rooms');
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM rooms WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($user_id, $title, $location, $size, $price, $description, $image) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO rooms (user_id, title, location, size, price, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)');
        return $stmt->execute([$user_id, $title, $location, $size, $price, $description, $image]);
    }

    public static function update($id, $title, $location, $size, $price, $description, $image) {
        global $pdo;
        $stmt = $pdo->prepare('UPDATE rooms SET title = ?, location = ?, size = ?, price = ?, description = ?, image = ? WHERE id = ?');
        return $stmt->execute([$title, $location, $size, $price, $description, $image, $id]);
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM rooms WHERE id = ?');
        return $stmt->execute([$id]);
    }
}