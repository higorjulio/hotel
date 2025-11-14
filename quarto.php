<?php
require_once __DIR__ . '/src/start.php';
require_once __DIR__ . '/templates/header.html';
require_once __DIR__ . '/src/models/Room.php';
require_once __DIR__ . '/src/controllers/AuthController.php';
require_once __DIR__ . '/src/models/Notification.php';

$error = '';
$room = null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $error = 'ID de quarto inválido.';
} else {
    $id = (int) $_GET['id'];
    $room = Room::findById($id);
    if (!$room) {
        $error = 'Quarto não encontrado.';
    }
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rent'])) {
    if (!isset($_SESSION['user'])) {
        $message = 'Você precisa fazer login para alugar este quarto.';
    } else {
        $userType = $_SESSION['user']['type'] ?? '';
        if ($userType === 'comprador' || $userType === 'admin') {
            $message = 'Reserva solicitada com sucesso.';
            Notification::create($room['user_id'], $_SESSION['user']['id'], 'reservation_requested', $room['id']);
        } else {
            $message = 'Apenas compradores podem alugar este quarto.';
        }
    }
}
?>

<div class="container mt-4">
    <?php if ($error): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
        <a href="quartos.php" class="btn btn-secondary">Voltar</a>
    <?php else: ?>
        <div class="row">
            <div class="col-md-6">
                <?php if (!empty($room['image'])): ?>
                    <img src="<?=htmlspecialchars($room['image'])?>" class="img-fluid" alt="<?=htmlspecialchars($room['title'])?>">
                <?php else: ?>
                    <img src="https://placehold.co/640x360?text=Sem+Imagem" class="img-fluid" alt="Sem imagem">
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <h2><?=htmlspecialchars($room['title'])?></h2>
                <p><b>Local:</b> <?=htmlspecialchars($room['location'])?></p>
                <p><b>Tamanho:</b> <?=htmlspecialchars($room['size'])?> m²</p>
                <p><b>Preço:</b> R$ <?=number_format((float)$room['price'], 2, ',', '.')?></p>
                <p><?=nl2br(htmlspecialchars($room['description']))?></p>

                <?php if ($message): ?>
                    <div class="alert alert-info"><?=htmlspecialchars($message)?></div>
                <?php endif; ?>

                <form method="post">
                    <button name="rent" class="btn btn-primary">Alugar</button>
                    <a href="quartos.php" class="btn btn-secondary">Voltar</a>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
