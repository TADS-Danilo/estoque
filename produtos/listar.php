
<?php

header("Content-Type: text/html; charset=UTF-8");

require_once "../classes/Produto.php";

$produto = new Produto();

$pesquisa = "";

if (isset($_GET["nome"])) {
    $pesquisa = trim($_GET["nome"]);
}

if ($pesquisa != "") {
    $produtos = $produto->consultarPorNome($pesquisa);
} else {
    $produtos = $produto->listar();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Consulta de Produtos</title>
</head>

<body>
    <?php include __DIR__ . "/../includes/menu.php"; ?>
    
    <h1>Consulta de Produtos</h1>

    <form method="GET">

        <label>Nome do produto:</label>

        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($pesquisa) ?>"
        >

        <button type="submit">Pesquisar</button>

        <a href="listar.php">Limpar pesquisa</a>

    </form>

    <br>

    <table border="1" cellpadding="8">

        <tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Categoria</th>
            <th>Quantidade</th>
            <th>Preço</th>
            <th>Localização</th>
            <th>Estoque mínimo</th>
            <th>Estoque máximo</th>
        </tr>

        <?php foreach ($produtos as $p) { ?>

            <tr>

                <td><?= $p["id"] ?></td>

                <td><?= htmlspecialchars($p["nome"]) ?></td>

                <td><?= htmlspecialchars($p["categoria"]) ?></td>

                <td><?= $p["quantidade"] ?></td>

                <td>
                    R$ <?= number_format($p["preco"], 2, ",", ".") ?>
                </td>

                <td><?= htmlspecialchars($p["localizacao"]) ?></td>

                <td><?= $p["estoque_minimo"] ?></td>

                <td><?= $p["estoque_maximo"] ?></td>

            </tr>

        <?php } ?>

        <?php if (count($produtos) == 0) { ?>

            <tr>
                <td colspan="8">Nenhum produto encontrado.</td>
            </tr>

        <?php } ?>

    </table>

</body>
</html>
