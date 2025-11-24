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

    // Insere um usuário vendedor de teste e um admin se não houver nenhum usuário
    $countUsers = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    if ($countUsers === 0) {
        $passwordHash = password_hash('vendedor', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)');
        $stmt->execute(['Vendedor Teste', 'vendedor@teste.local', $passwordHash, 'vendedor']);

        $passwordHash = password_hash('admin', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)');
        $stmt->execute(['Admin', 'admin@root.com', $passwordHash, 'admin']);
    }

    // garante que temos um user_id válido para relacionar aos quartos
    $sellerId = (int) $pdo->query('SELECT id FROM users WHERE type = "vendedor" LIMIT 1')->fetchColumn();
    if (!$sellerId) {
        // pega qualquer usuário existente
        $sellerId = (int) $pdo->query('SELECT id FROM users LIMIT 1')->fetchColumn();
    }

    // Se não houver quartos, inserir 6 quartos de exemplo
    $countRooms = (int) $pdo->query('SELECT COUNT(*) FROM rooms')->fetchColumn();
    if ($countRooms === 0 && $sellerId) {
        $insertRoom = $pdo->prepare('INSERT INTO rooms (user_id, title, location, size, price, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $samples = [
            ['Suíte Premium', 'Centro', 70, 2800.00, 'Entrega conforto elevado com estilo e praticidade.', 'https://i.ibb.co/VYxbb9Dm/suite-premium.jpg'],
            ['Suíte Basic', 'Centro', 20, 650.00, 'Ambiente aconchegante, simplicidade e uma boa estadia.', 'https://i.ibb.co/9HZJRxmp/suite-basic.jpg'],
            ['Suíte Confort', 'Centro', 30, 1200.00, 'Espaçosa, com 2 camas e sofá-cama para uma estadia tranquila.', 'https://i.ibb.co/cSMcFK6m/suite-confort.jpg'],
            ['Quarto Classic', 'Centro', 20, 500.00, 'Quarto clássico, bom para viajantes.', 'https://i.ibb.co/vCvwWfjW/quarto-classic.jpg'],
            ['Quarto Superior', 'Centro', 30, 850.00, 'Combina conforto extra, ambiente refinado e comodidades ampliadas.', 'https://i.ibb.co/60gf8m26/quarto-superior.jpg'],
            ['Quarto Deluxe', 'Beira Mar', 50, 3000.00, 'Vista para o mar, cama king-size e jacuzzi para uma experiência sofisticada.', 'https://i.ibb.co/8LzppdMq/quarto-deluxe-beira-mar.jpg']
        ];
        foreach ($samples as $s) {
            $insertRoom->execute([$sellerId, $s[0], $s[1], $s[2], $s[3], $s[4], $s[5]]);
        }
    }
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