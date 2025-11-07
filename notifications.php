<?php
require_once __DIR__ . '/src/start.php';
require_once __DIR__ . '/templates/header.html';
require_once __DIR__ . '/src/controllers/AuthController.php';
require_once __DIR__ . '/src/models/Notification.php';
AuthController::requireVendedor();
?>
<style>
    
</style>
<h2 class="head">Notificações</h2>

<?php
$sql = "SELECT n.*, u.name AS sender_name 
FROM notifications n 
JOIN users u 
ON n.sender_id = u.id 
WHERE n.receiver_id = ? 
ORDER BY n.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user']['id']]);
$typeDescriptions = Notification::type();
foreach ($stmt as $notification) {
    $typeText = $typeDescriptions[$notification['type']] ?? 'Notificação';
    
    //Transformar a data
    $dt = new DateTime($notification['created_at']);
    $dt -> setTimezone(new DateTimeZone("America/Recife"));
    $createdAt = $dt->format('d/m/Y H:i');
    ?>
    <div class="notificacao mb-3 p-3 border rounded">
    <div class="texto">
    <b><?=htmlspecialchars($typeText)?></b><br>
    De: <?=htmlspecialchars($notification['sender_name'])?><br>
    Data: <?=htmlspecialchars($createdAt)?><br>
    </div>
    </div>
    <?php
}
?>

<!-- <div class="notificacao">
    <div class="texto">
        
    </div>
</div> -->