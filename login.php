<?php
require_once "src/start.php";
require_once "src/controllers/AuthController.php";
$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['type'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $type = $_POST['type'];
        if (AuthController::register($name, $email, $password, $type)) {
            header('Location: login.php');
            exit;
        } else {
            $error = "Erro ao registrar. E-mail já está em uso.";
        }
    } elseif (isset($_POST['email'], $_POST['password'])) {
        // Login
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        if (AuthController::login($email, $password)) {
            header('Location: index.php');
            exit;
        } else {
            $error = "E-mail ou senha inválidos.";
        }
    }
}
?>
<link rel="stylesheet" href="assets/css/login.css">

<!-- isolar o login do restante do layout -->
<style>
.login-page {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f5f0e1;
}
</style>

<script>
    function showRegister() {
        document.getElementById('login-form').classList.add('hidden');
        document.getElementById('register-form').classList.remove('hidden');
    }
    function showLogin() {
        document.getElementById('register-form').classList.add('hidden');
        document.getElementById('login-form').classList.remove('hidden');
    }
</script>

<!-- contêiner da página de login -->
<div class="login-page">

<div class="">
    <form id="login-form" method="post" action="login.php">
        <h2>Login</h2>
        <?php
        if($error){
            echo $error;
            return;
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
        <button type="button" onclick="showRegister()">Cadastrar</button>
    </form>
    <form id="register-form" class="hidden" method="post" action="login.php">
        <h2>Cadastrar</h2>
        <?php
        if($error){
            echo $error;
            return;
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
        <button type="submit">Registrar</button>
        <button type="button" onclick="showLogin()">Voltar</button>
    </form>
</div>
</div>
