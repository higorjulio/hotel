<?php
require_once __DIR__ . '/src/start.php';
require_once __DIR__ . '/templates/header.html';
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

  <!-- Conteúdo exemplo -->
  <section class="container my-5">
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card card-feature">
          <img src="assets/img/quarto1.jpg" class="card-img-top" alt="Quarto 1">
          <div class="card-body">
            <h5 class="card-title">Quarto Standard</h5>
            <p class="card-text">Descrição breve do quarto standard, confortável e bem localizado.</p>
            <a href="quarto.php?id=1" class="btn btn-secondary">Ver Mais</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card card-feature">
          <img src="assets/img/quarto2.jpg" class="card-img-top" alt="Quarto 2">
          <div class="card-body">
            <h5 class="card-title">Quarto Deluxe</h5>
            <p class="card-text">Versão deluxe com vista, mais espaço e conforto extra.</p>
            <a href="quarto.php?id=2" class="btn btn-secondary">Ver Mais</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card card-feature">
          <img src="assets/img/quarto3.jpg" class="card-img-top" alt="Quarto 3">
          <div class="card-body">
            <h5 class="card-title">Suíte Premium</h5>
            <p class="card-text">Suíte premium para quem busca o melhor conforto e estilo.</p>
            <a href="quarto.php?id=3" class="btn btn-secondary">Ver Mais</a>
          </div>
        </div>
      </div>
    </div>
  </section>

<footer class="footer text-center py-4">
    <div class="container">
      <p class="mb-0">© 2025 Hotelys – Todos os direitos reservados</p>
    </div>
  </footer>