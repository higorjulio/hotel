<?php
$host = 'localhost';
$db   = 'hotel2';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria a tabela users caso não exista
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        type ENUM('comprador','vendedor', 'admin') NOT NULL
    )");
    $pdo-> exec("CREATE TABLE IF NOT EXISTS rooms (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(100) NOT NULL,
        location VARCHAR(100) NOT NULL,
        size INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        description TEXT,
        image VARCHAR(255),
        is_rented BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (user_id) REFERENCES users(id)
    );
        ");
    $pdo-> exec("CREATE TABLE IF NOT EXISTS notifications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        receiver_id INT NOT NULL,  -- ID de quem recebe a notificaçõo
        sender_id INT NOT NULL, -- ID do usuário que alugou o quarto
        room_id INT NOT NULL, -- ID do quarto relacionado à notificação
        type ENUM(
        'reservation_requested', 
        'reservation_accepted', 
        'reservation_rejected',
        'room_rented' 
        ) NOT NULL,
        is_read BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (receiver_id) REFERENCES users(id),
        FOREIGN KEY (sender_id) REFERENCES users(id),
        FOREIGN KEY (room_id) REFERENCES rooms(id)
    )
        ");
} catch (\PDOException $e) {
    //cria um banco de dados se ele não existir
    if ($e->getCode() == 1049) { 
        $pdo = new PDO("mysql:host=$host;charset=$charset", $user, $pass, $options);
        $pdo->exec("CREATE DATABASE `$db` CHARACTER SET $charset COLLATE ${charset}_general_ci");
        $pdo = new PDO($dsn, $user, $pass, $options);
    } else {
        throw $e;
    }
}
?>