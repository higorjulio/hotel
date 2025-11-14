<?php
require_once __DIR__ . '/../db.php';

class Notification{

    public static function create($receiver_id, $sender_id, $type, $room_id){
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO notifications (receiver_id, sender_id, type, room_id) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$receiver_id, $sender_id, $type, $room_id]);
    }
    public static function type(){
        return [
            'reservation_requested' => 'Reserva solicitada',
            'reservation_accepted' => 'Reserva aceita',
            'reservation_rejected' => 'Reserva rejeitada',
            'room_rented' => 'Quarto alugado'
        ];
    }

}