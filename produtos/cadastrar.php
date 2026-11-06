
<?php

header("Content-Type: text/html; charset=UTF-8");

require_once "../classes/Produto.php";
require_once "../classes/Categoria.php";

$categoria = new Categoria();
$categorias = $categoria->listar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $produto = new Produto(
        trim($_POST["nome"]),
        $_POST["categoria_id"],
        $_POST["quantidade"],
        $_POST["preco"],
        trim($_POST["localizacao"]),
        $_POST["estoque_minimo"],
        $_POST["estoque_maximo"]
    );

    if ($produto->cadastrar()) {
        $mensagem = "Produto cadastrado com sucesso!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produtos</title>
</head>
<body>
    <?php include __DIR__ . "/../includes/menu.php"; ?>
    
    <h1>Cadastro de Produtos</h1>

    <?php if (isset($mensagem)) { ?>
        <p><?= htmlspecialchars($mensagem) ?></p>
    <?php } ?>

    <form method="POST">

        <label>Nome:</label>
        <input type="text" name="nome" required>
        <br><br>

        <label>Categoria:</label>
        <select name="categoria_id" required>
            <option value="">Selecione</option>

            <?php foreach ($categorias as $cat) { ?>
                <option value="<?= $cat["id"] ?>">
                    <?= htmlspecialchars($cat["nome"]) ?>
                </option>
            <?php } ?>

        </select>
        <br><br>

        <label>Quantidade:</label>
        <input type="number" name="quantidade" min="0" required>
        <br><br>

        <label>Preço:</label>
        <input type="number" name="preco" step="0.01" min="0" required>
        <br><br>

        <label>Localização:</label>
        <input type="text" name="localizacao" required>
        <br><br>

        <label>Estoque mínimo:</label>
        <input type="number" name="estoque_minimo" min="0" required>
        <br><br>

        <label>Estoque máximo:</label>
        <input type="number" name="estoque_maximo" min="0" required>
        <br><br>

        <button type="submit">Cadastrar Produto</button>

    </form>

</body>
</html>
