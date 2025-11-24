<?php
require_once __DIR__ . '/src/start.php';
require_once __DIR__ . '/src/controllers/AuthController.php';
require_once __DIR__ . '/src/models/Notification.php';
require_once __DIR__ . '/src/models/Room.php';
AuthController::requireLogin();
require_once __DIR__ . '/templates/header.php';
?>
<style>
    .notificacao {
        background: #fff8f0; /* bege claro */
        border: 1px solid var(--marrom-claro);
        border-left: 5px solid var(--marrom-escuro);
        border-radius: 10px;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        transition: 0.2s;
    }
    
    .notificacao:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    
    .notificacao .texto {
        color: var(--marrom-escuro);
        font-size: 1rem;
    }
    
.notificacao b {
    color: var(--marrom-claro);
    font-size: 1.1rem;
}

.btn-success,
.btn-danger {
    padding: 6px 12px;
    font-weight: bold;
    border-radius: 6px;
}

.btn-success {
    background-color: var(--marrom-claro);
    border: none;
}

.btn-success:hover {
    background-color: var(--marrom-escuro);
}

.btn-danger {
    background-color: #b54a4a;
    border: none;
}

.btn-danger:hover {
    background-color: #8a3535;
}

.head {
    text-align: center;
    margin: 25px 0;
    color: var(--marrom-escuro);
    font-weight: bold;
}
a{
    color: var(--marrom-escuro);
}
</style>
<h2 class="head">Notificações</h2>

<?php
$sql = "SELECT n.*, u.name AS sender_name 
FROM notifications n 
JOIN users u 
ON n.sender_id = u.id 
WHERE n.receiver_id = ? 
ORDER BY n.created_at DESC";
if($_SESSION['user']['type'] === 'vendedor'){
    $sql = "SELECT n.*, u.name AS sender_name 
    FROM notifications n 
    JOIN users u 
    ON n.sender_id = u.id 
    WHERE n.receiver_id = ? 
    ORDER BY n.created_at ASC";
}
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user']['id']]);
$typeDescriptions = Notification::type();
foreach ($stmt as $notification) {
    $typeText = $typeDescriptions[$notification['type']] ?? 'Notificação';
    
    //Transformar a data
    $dt = new DateTime($notification['created_at']);
    // $dt -> setTimezone(new DateTimeZone("America/Recife"));
    $createdAt = $dt->format('d/m/Y H:i');

    $roomTitle = Room::findById($notification['room_id'])['title']
    ?>
    <div class="notificacao mb-3 p-3 border rounded">
    <div class="texto">
    <b><?=htmlspecialchars($typeText)?></b><br>
    De: <?=htmlspecialchars($notification['sender_name'])?><br>
    Quarto: <a href='quarto.php?id=<?=htmlspecialchars($notification['room_id'])?>'><?=htmlspecialchars($roomTitle)?></a><br>
    Data: <?=htmlspecialchars($createdAt)?><br>
        <?php
    if ($notification['type'] === 'reservation_requested') {
        echo "Aceitar?";
        ?>
        <br>
        <form method="post" style="display:inline-block">
            <input type="hidden" name="notification_id" value="<?= (int)$notification['id'] ?>">
            <input type="hidden" name="action" value="accept">
            <button type="submit" class="btn btn-success">Aceitar</button>
        </form>
        <form method="post" style="display:inline-block; margin-left:8px;">
            <input type="hidden" name="notification_id" value="<?= (int)$notification['id'] ?>">
            <input type="hidden" name="action" value="reject">
            <button type="submit" class="btn btn-danger">Rejeitar</button>
        </form>

        <!-- <button class="btn btn-success aceitar">Aceitar</button>
        <button class="btn btn-danger rejeitar">Rejeitar</button> -->
        <?php
    }
    ?>
    </div>
    </div>
    <?php
}
if($stmt->rowCount() === 0){
    echo "<h5 class='text-secondary text-center'>Nenhuma notificação encontrada.</h5>";
}
?>
<!-- TODO: -->
<!-- Sistema de aceitar e negar -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['notification_id'])){
$action = $_POST['action'];
    $notificationId = (int) $_POST['notification_id'];
    
    $stmtN = $pdo->prepare('SELECT * FROM notifications WHERE id = ? LIMIT 1');
    $stmtN->execute([$notificationId]);
    $notif = $stmtN->fetch();
    if ($notif) {
        $senderId = $notif['sender_id'];
        $roomId = $notif['room_id'] ?? null;
        $currentUserId = $_SESSION['user']['id'];
        if ($action === 'accept') {
            // if ($roomId) {
            //     Room::delete($roomId);
            // }
            Notification::create($senderId, $currentUserId, 'reservation_accepted', $roomId);
            Room::rented($roomId);
             $pdo->prepare('DELETE FROM notifications WHERE id = ?')->execute([$notificationId]);
        } elseif ($action === 'reject') {
            Notification::create($senderId, $currentUserId, 'reservation_rejected', $roomId);
            $pdo->prepare('DELETE FROM notifications WHERE id = ?')->execute([$notificationId]);
        }
        header('Location: ' . ($_SERVER['REQUEST_URI'] ?? 'notificacoes.php'));
        exit;
    }
}
?>