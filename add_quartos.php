<?php
require_once "src/start.php";
require_once "templates/header.html";
require_once "src/models/Room.php";
require_once "src/controllers/AuthController.php";
AuthController::requireLogin();
authController::requireVendedor();
?>

<?php
//TODO: verificar link das imagens
    $error = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $userSessionID = htmlspecialchars($_SESSION['user']['id']);

    if(isset($_POST['title'], $_POST['location'], $_POST['size'], $_POST['price'], $_POST['description'])) {
        $title = trim($_POST['title']);
        $location = trim($_POST['location']);
        $size = trim($_POST['size']);
        $price = trim($_POST['price']);
        $description = trim($_POST['description']);
        $imagePath = null;
        if (isset($_POST['image'])) {
            $img = trim($_POST['image']);
            if ($img !== '') {
                // valida URL
                if (filter_var($img, FILTER_VALIDATE_URL)) {
                        $imagePath = $img;
                    } else {
                        $error = "Link de imagem inválido";
                    }
                } else {
                    $error = "Link de imagem inválido.";
                }
            }
        } else {
            $imagePath = null;
        }

        if (Room::create($userSessionID, $title, $location, $size, $price, $description, $imagePath)) {
            header('Location: quartos.php');
            exit;
        } else {
            $error = "Erro ao adicionar quarto. Tente novamente.";
        }
    } else {
        $error = "Por favor, preencha todos os campos obrigatórios.";
}
?>

<div class="container-sm">
    <h2>Adicionar Quarto</h2>
    <form method="post">
        <div class="mb-auto">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-auto">
            <label for="location" class="form-label">Localização</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="mb-auto">
            <label for="size" class="form-label">Metros quadrados (m2)</label>
            <input type="text" class="form-control" id="size" name="size" required>
        </div>
        <div class="mb-auto">
            <label for="price" class="form-label">Preço</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <div class="mb-auto">
            <label for="decription" class="form-label">Descrição</label>
            <textarea name="description" class="form-control" rows=3></textarea>
        </div>
        <div class="mb-auto">
            <label for="image" class="form-label">Link da Imagem</label>
            <input type="text" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-success mt-3 ">Adicionar Quarto</button>
        <?php
        if($error) {
            echo "<div class='alert alert-danger mt-3'>$error</div>";
        }
        ?>
        </form>
</div>