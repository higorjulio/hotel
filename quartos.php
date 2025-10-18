<?php
require_once "src/start.php";
require_once "templates/header.html";
require_once "src/models/Room.php";
?>
<?php

$rooms = Room::getAll();

?>

<div class="container mt-4">
    <div class="row">
    <?php foreach($rooms as $room){ ?>

        <div class="col-md-4 d-flex align-items-stretch">
            <div class="card mb-4 w-100">
    <?php if(!empty($room['image'])): ?>
        <img src="<?=htmlspecialchars($room['image'])?>" class="card-img-top" alt="<?=htmlspecialchars($room['title'])?>">
    <?php else: ?>
        <img src="https://placehold.co/320x180?text=Sem+Imagem" class="card-img-top" alt="Sem imagem">
    <?php endif; ?>
    <div class="card-body">
        <h5 class="card-title"><?=htmlspecialchars($room['title'])?></h5>
        <p class="card-text mb-1"><b>Local:</b> <?=htmlspecialchars($room['location'])?></p>
        <p class="card-text mb-1"><b>Tamanho:</b> <?=htmlspecialchars($room['size'])?> m²</p>
        <p class="card-text mb-2"><b>Preço:</b> R$ <?=number_format((float)$room['price'], 2, ',', '.')?></p>
        <a href="quarto.php?id=<?=urlencode($room['id'])?>" class="btn btn-primary">Ver detalhes</a>
    </div>
            </div>
        </div>

    <?php } ?>
    </div>
</div>

<?php
?>