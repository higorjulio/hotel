<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Lotus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/logo.png" type="image/x-icon">   
    
    <!-- CSS para o Modal de Login -->
    <style>
      /* Overlay escuro */
      .login-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        z-index: 1040;
        animation: fadeIn 0.3s ease;
      }

      .login-overlay.active {
        display: block;
      }

      @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
      }

      /* Modal que desliza da direita */
      .login-modal {
        position: fixed;
        top: 0;
        right: -500px;
        width: 450px;
        height: 100vh;
        background: linear-gradient(180deg, #fff 0%, #fffaf3 100%);
        box-shadow: -4px 0 16px rgba(0, 0, 0, 0.2);
        z-index: 1050;
        overflow-y: auto;
        transition: right 0.4s ease;
        padding: 2rem;
      }

      .login-modal.active {
        right: 0;
      }

      .login-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--bege-mediano);
      }

      .login-modal-header h2 {
        margin: 0;
        color: var(--marrom-claro);
        font-weight: 700;
      }

      .login-modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--marrom);
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .login-modal-close:hover {
        color: var(--marrom-escuro);
        transform: scale(1.1);
      }

      /* Formulários dentro do modal */
      .login-modal form {
        background: transparent;
        border: none;
        padding: 0;
        width: 100%;
        box-shadow: none;
      }

      .login-modal form h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: var(--marrom-claro);
        font-size: 1.5rem;
      }

      .login-modal form label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--marrom-claro);
        font-weight: 600;
      }

      .login-modal form input[type="text"],
      .login-modal form input[type="email"],
      .login-modal form input[type="password"],
      .login-modal form select {
        width: 100%;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        border: 2px solid var(--bege-mediano);
        border-radius: 8px;
        background-color: #fffdf5;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
      }

      .login-modal form input:focus,
      .login-modal form select:focus {
        outline: none;
        border-color: var(--marrom-claro);
        box-shadow: 0 0 0 3px rgba(140, 94, 60, 0.1);
      }

      .login-modal form button {
        width: 48%;
        padding: 0.75rem 1rem;
        margin-top: 0.5rem;
        margin-right: 1%;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
      }

      .login-modal form button[type="submit"] {
        background: linear-gradient(135deg, var(--marrom-claro) 0%, var(--marrom) 100%);
        color: #fff;
        box-shadow: 0 4px 12px rgba(59, 36, 24, 0.15);
      }

      .login-modal form button[type="submit"]:hover {
        background: linear-gradient(135deg, var(--marrom) 0%, var(--marrom-escuro) 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(59, 36, 24, 0.2);
      }

      .login-modal form button[type="button"] {
        background: linear-gradient(135deg, var(--bege-mediano) 0%, #f0dfc5 100%);
        color: var(--marrom-claro);
        box-shadow: 0 2px 8px rgba(59, 36, 24, 0.08);
      }

      .login-modal form button[type="button"]:hover {
        background: linear-gradient(135deg, #f0dfc5 0%, var(--bege-mediano) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 36, 24, 0.12);
      }

      .login-modal form .error {
        color: #d32f2f;
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        text-align: center;
        font-weight: 600;
        border-left: 4px solid #d32f2f;
      }

      .hidden {
        display: none;
      }

      /* Responsividade */
      @media (max-width: 576px) {
        .login-modal {
          width: 100%;
          right: -100%;
          padding: 1.5rem;
        }

        .login-modal form button {
          width: 100%;
          margin-right: 0;
          margin-bottom: 0.5rem;
        }
      }
    </style>
  </head>
  
<body>

    <!-- Navbar principal -->
  <nav class="navbar navbar-expand-lg navbar-light custom-navbar py-3">
    <div class="container">
      <i class="logo">
         <img src="assets/logo.png" width="90" height="90">
      </i>
      <a class="navbar-brand text-brand" href="index.php">Lotus</a>
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
            <!-- Botão que abre o modal de login -->
            <a class="nav-link text-nav icon-link" href="#" id="login-btn" onclick="openLoginModal(event)">
              <i class="bi bi-person-circle me-1"></i>Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Overlay (fundo escuro) -->
  <div class="login-overlay" id="login-overlay" onclick="closeLoginModal()"></div>

  <!-- Login que desliza da direita -->
  <div class="login-modal" id="login-modal">
    <div class="login-modal-header">
      <h2 id="modal-title">Login</h2>
      <button class="login-modal-close" onclick="closeLoginModal()">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>

    <!-- Formulário de Login -->
    <form id="login-form" method="post" action="index.php">
      <?php
      if(isset($error) && $error) {
          echo '<div class="error">' . htmlspecialchars($error) . '</div>';
      }
      ?>
      <div class="mb-3">
        <label for="login-email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="login-email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="login-password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="login-password" name="password" required>
      </div>
      <button type="submit">Entrar</button>
      <button type="button" onclick="showRegisterForm()">Cadastrar</button>
    </form>

    <!-- Formulário de Registro -->
    <form id="register-form" class="hidden" method="post" action="index.php">
      <?php
      if(isset($error) && $error) {
          echo '<div class="error">' . htmlspecialchars($error) . '</div>';
      }
      ?>
      <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="mb-3">
        <label for="type" class="form-label">Tipo de usuário</label>
        <select class="form-select" id="type" name="type">
          <option value="comprador">Comprador</option>
          <option value="vendedor">Vendedor</option>
        </select>
      </div>
      <button type="submit">Registrar</button>
      <button type="button" onclick="showLoginForm()">Voltar</button>
    </form>
  </div>

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

  <!-- JavaScript para controlar o modal -->
  <script>
    // Abrir modal de login
    function openLoginModal(event) {
      event.preventDefault();
      document.getElementById('login-modal').classList.add('active');
      document.getElementById('login-overlay').classList.add('active');
      document.body.style.overflow = 'hidden'; // Previne scroll
    }

    // Fechar modal de login
    function closeLoginModal() {
      document.getElementById('login-modal').classList.remove('active');
      document.getElementById('login-overlay').classList.remove('active');
      document.body.style.overflow = 'auto'; // Permite scroll novamente
    }

    // Mostrar formulário de registro
    function showRegisterForm() {
      document.getElementById('login-form').classList.add('hidden');
      document.getElementById('register-form').classList.remove('hidden');
      document.getElementById('modal-title').textContent = 'Cadastrar';
    }

    // Mostrar formulário de login
    function showLoginForm() {
      document.getElementById('register-form').classList.add('hidden');
      document.getElementById('login-form').classList.remove('hidden');
      document.getElementById('modal-title').textContent = 'Login';
    }

    // Fechar modal ao pressionar ESC
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closeLoginModal();
      }
    });
  </script>

  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
