
<?php
header("Content-Type: text/html; charset=UTF-8");
require_once "../classes/Categoria.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        $nome = trim($_POST["nome"]);

        $categoria = new Categoria($nome);
        $categoria->cadastrar();

        $mensagem = "Categoria cadastrada com sucesso!";

    } catch (Exception $e) {

        $erro = $e->getMessage();
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

    <?php if (!empty($mensagem)) { ?>
        <p style="color: green;">
            <?= htmlspecialchars($mensagem) ?>
        </p>
    <?php } ?>

    <?php if (!empty($erro)) { ?>
        <p style="color: red;">
            <?= htmlspecialchars($erro) ?>
        </p>
    <?php } ?>

    <form method="POST">

        <label>Nome da categoria:</label>
        <input type="text" name="nome" required>

        <button type="submit">Cadastrar</button>

    </form>

</body>
</html>
