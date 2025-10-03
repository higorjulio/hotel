<?php
require_once "../src/start.php";
require_once "../src/controllers/AuthController.php";
AuthController::requireAdmin();
require_once "../templates/header.html";
?>

<table class="table table-bordered border border-secondary-subtle">
    <?php
    $sql = "SELECT * FROM users";
    $usuarios = $pdo->query($sql);
    if ($usuarios && $usuarios->rowCount() > 1) {
        ?>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
            </tr>
        </thead>
    <?php
        foreach($usuarios as $usuario) {
    
    ?>
    <tbody>
        <tr>
            <td><?=$usuario["id"]?></td>
            <td><?=$usuario["name"]?></td>
            <td><?=$usuario["email"]?></td>
        </tr>
        <?php
        }
    } else{
        echo "<h5 class=text-secondary>Nenhum usuário encontrado.</h5>";
    }
    ?>
    </tbody>
</table>