<?php

header("Content-Type: text/html; charset=UTF-8");

require_once __DIR__ . "/../classes/Movimentacao.php";
require_once __DIR__ . "/../classes/Produto.php";
require_once __DIR__ . "/../config/Conexao.php";

$produto = new Produto();
$produtos = $produto->listar();

$mensagem = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $movimentacao = new Movimentacao(
            $_POST["produto_id"],
            $_POST["tipo"],
            $_POST["quantidade"],
            trim($_POST["observacao"])
        );

        $movimentacao->registrar();

        $mensagem = "Movimentação registrada com sucesso!";

        // Atualiza a lista de produtos após a movimentação
        $produtos = $produto->listar();

    } catch (Exception $e) {

        $erro = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Movimentação de Estoque</title>
</head>

<body>
    <?php include __DIR__ . "/../includes/menu.php"; ?>

    <h1>Registrar Movimentação de Estoque</h1>

    <?php if ($mensagem != "") { ?>
        <p style="color: green;">
            <?= htmlspecialchars($mensagem) ?>
        </p>
    <?php } ?>

    <?php if ($erro != "") { ?>
        <p style="color: red;">
            <?= htmlspecialchars($erro) ?>
        </p>
    <?php } ?>

    <form method="POST">

        <label>Produto:</label><br>

        <select name="produto_id" required>

            <option value="">Selecione um produto</option>

            <?php foreach ($produtos as $p) { ?>

                <option value="<?= $p["id"] ?>">
                    <?= htmlspecialchars($p["nome"]) ?>
                    (Estoque atual: <?= $p["quantidade"] ?>)
                </option>

            <?php } ?>

        </select>

        <br><br>

        <label>Tipo de movimentação:</label><br>

        <select name="tipo" required>
            <option value="">Selecione</option>
            <option value="ENTRADA">Entrada</option>
            <option value="SAIDA">Saída</option>
        </select>

        <br><br>

        <label>Quantidade:</label><br>

        <input
            type="number"
            name="quantidade"
            min="1"
            required
        >

        <br><br>

        <label>Observação:</label><br>

        <textarea name="observacao" rows="3" cols="40"></textarea>

        <br><br>

        <button type="submit">Registrar movimentação</button>

    </form>

    <br>

    <a href="../produtos/listar.php">Consultar produtos</a>

</body>
</html>