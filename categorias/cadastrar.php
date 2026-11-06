
<?php
header("Content-Type: text/html; charset=UTF-8");
require_once "../classes/Categoria.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);

    if ($nome != "") {

        $categoria = new Categoria($nome);

        if ($categoria->cadastrar()) {
            $mensagem = "Categoria cadastrada com sucesso!";
        }

    } else {
        $mensagem = "Informe o nome da categoria.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Categorias</title>
</head>
<body>
    <?php include __DIR__ . "/../includes/menu.php"; ?>

    <h1>Cadastro de Categorias</h1>

    <?php if (isset($mensagem)) { ?>
        <p><?= htmlspecialchars($mensagem) ?></p>
    <?php } ?>

    <form method="POST">

        <label>Nome da categoria:</label>
        <input type="text" name="nome" required>

        <button type="submit">Cadastrar</button>

    </form>

</body>
</html>
