<?php

header("Content-Type: text/html; charset=UTF-8");

require_once __DIR__ . "/../classes/Produto.php";

$produto = new Produto();

$localizacao = trim($_GET["localizacao"] ?? "");

$produtos = [];

if ($localizacao != "") {
    $produtos = $produto->consultarPorLocalizacao($localizacao);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Localizar Produtos</title>
</head>

<body>
    <?php include __DIR__ . "/../includes/menu.php"; ?>
    
    <h1>Localizar Produtos no Estoque</h1>

    <form method="GET">

        <label>Localização:</label>

        <input
            type="text"
            name="localizacao"
            value="<?= htmlspecialchars($localizacao) ?>"
            placeholder="Ex.: A1-P2"
            required
        >

        <button type="submit">Pesquisar</button>

    </form>

    <br>

    <?php if ($localizacao != "") { ?>

        <h2>Resultados da pesquisa</h2>

        <table border="1" cellpadding="8">

            <tr>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Quantidade</th>
                <th>Localização</th>
            </tr>

            <?php foreach ($produtos as $p) { ?>

                <tr>
                    <td><?= htmlspecialchars($p["nome"]) ?></td>
                    <td><?= htmlspecialchars($p["categoria"]) ?></td>
                    <td><?= $p["quantidade"] ?></td>
                    <td><?= htmlspecialchars($p["localizacao"]) ?></td>
                </tr>

            <?php } ?>

            <?php if (count($produtos) == 0) { ?>

                <tr>
                    <td colspan="4">Nenhum produto encontrado nesta localização.</td>
                </tr>

            <?php } ?>

        </table>

    <?php } ?>

    <br>

    <a href="listar.php">Consultar todos os produtos</a>

</body>
</html>