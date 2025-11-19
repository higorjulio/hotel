<?php
require_once "../src/start.php";
require_once "../src/controllers/AuthController.php";
AuthController::requireAdmin();
require_once "../templates/header.php";
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
                <th>Tipo</th>
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
            <td>
                <?php
                    switch ($usuario["type"]) {
                        case "admin": echo "Admin"; break;
                        case "comprador": echo "Comprador"; break;
                        case "vendedor": echo "Vendedor"; break;
                        default: echo htmlspecialchars($usuario["type"]);
                    }
                ?>
            </td>
        </tr>
        <?php
        }
    } else{
        echo "<h5 class=text-secondary>Nenhum usuário encontrado.</h5>";
    }
    ?>
    </tbody>
</table>