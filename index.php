<?php
require_once __DIR__ . '/src/start.php';
require_once __DIR__ . '/templates/header.php';
require_once __DIR__ . "/src/models/Room.php";
?>

 </head>
<style>
  #login, #notifications {
    font-size: 150%;
    color: #000;
  }
a{
    text-decoration: none;
  }
</style>



  <!-- Hero Section -->
  <section class="hero text-center py-5">
    <div class="container">
      <h1 class="fw-bold hero-title">Bem-vindo ao BelMar</h1>
      <p class="hero-subtitle">Conforto, praticidade e elegância no seu descanso.</p>
      <a href="quartos.php" class="btn btn-primary btn-cta mt-3">Ver Quartos</a>
    </div>
  </section>

  <!-- Quartos -->
  <section class="container my-5">
    <div class="row">
      <?php
      $rooms = Room::getAll();
      $lista = [];
      $quartos = [];
      foreach($rooms as $room){
        if(!$room["is_rented"]){
          $lista[] = $room;
        }
      }
      
      $quartos = [];
      if(count($lista) <= 0) {
        echo "<h1>Nenhum quarto disponível no momento.</h1>";
        echo "<p>Deseja adicionar um quarto?</p>";
        echo '<a href="add_quartos.php" class="btn btn-primary ">Adicionar Quarto</a>';
      }else{
      $keys = array_rand($lista, 3);
      foreach($keys as $keys){
      $quartos[] = $lista[$keys];
      }
      foreach($quartos as $quarto){
      ?>
      <div class="col-md-4 mb-4">
        <div class="card card-feature">
          <img src=<?=$quarto["image"] ?? "https://placehold.co/320x180?text=Sem+Imagem"?> class="card-img-top" alt=<?=$quarto["title"]?>>
          <div class="card-body">
            <h5 class="card-title"><?=$quarto["title"]?></h5>
            <p class="card-text"><?=$quarto["description"] ?? "Sem descrição"?></p>
            <a href="quarto.php?id=<?=$quarto["id"]?>" class="btn btn-secondary">Ver Mais</a>
          </div>
        </div>
      </div>
      <?php } }?>
  </section>

<footer class="footer text-center py-4">
    <div class="container">
      <p class="mb-0">© 2025 Hotel BelMar – Todos os direitos reservados</p>
    </div>
  </footer>