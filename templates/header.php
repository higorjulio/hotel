<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel BelMar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <style>
  ::selection {
  background-color: var(--marrom);
  color: var(--bege-claro);
}
  .whatsapp-float {
      position: fixed;
      width: 70px;
      height: 70px;
      bottom: 20px;
      right: 20px;
      background-color: #25d366;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 100px rgba(0,0,0,0.2);
      z-index: 9999;
  }
  .whatsapp-icon { 
      width: 40px;
      height: 40px;
  }
  .whatsapp-badge {
      position: fixed;
      bottom: 75px;
      right: 20px;
      background-color: red;
      color: white;
      font-size: 14px;
      font-weight: bold;
      width: 22px;
      height: 22px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 10000;
      border: 2px solid white;
      box-shadow: 0 0 6px rgba(0,0,0,0.2);
  }
</style>
<body>

    <!-- Navbar principal -->
  <nav class="navbar navbar-expand-lg navbar-light custom-navbar py-3">
    <div class="container">
      <a class="navbar-brand text-brand" href="index.php">BelMar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navMenu">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item">
            <a class="nav-link text-nav" href="index.php">Página Inicial</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-nav" href="quartos.php">Quartos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-nav icon-link" href="notificacoes.php" id="notifications">
              <i class="bi bi-bell-fill me-1"></i>Notificações
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-nav icon-link" href="login.php" id="login">
              <i class="bi bi-person-circle me-1"></i>Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <?php
  $telefone = "40028922"; 
  $mensagem = "Olá! Gostaria de mais informações.";
  $link_whatsapp = "https://wa.me/$telefone?text=" . urlencode($mensagem);
  ?>

  <!-- Botão do whatsApp -->
  <a href="<?php echo $link_whatsapp; ?>" class="whatsapp-float" target="_blank">
      <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"
            alt="WhatsApp" class="whatsapp-icon">
  </a>

  <div class="whatsapp-badge"></div>

  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>