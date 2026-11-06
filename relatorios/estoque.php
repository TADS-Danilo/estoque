<?php

header("Content-Type: text/html; charset=UTF-8");

require_once __DIR__ . "/../classes/Relatorio.php";

$relatorio = new Relatorio();

$tipo = $_GET["tipo"] ?? "geral";

if ($tipo == "baixo") {
    $produtos = $relatorio->estoqueBaixo();
    $titulo = "Produtos com Estoque Baixo";

} elseif ($tipo == "excessivo") {
    $produtos = $relatorio->estoqueExcessivo();
    $titulo = "Produtos com Estoque Excessivo";

} else {
    $produtos = $relatorio->posicaoEstoque();
    $titulo = "Posição Geral do Estoque";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Relatórios de Estoque</title>
</head>

<body>
    <?php include __DIR__ . "/../includes/menu.php"; ?>
    
    <h1>Relatórios de Estoque</h1>

    <nav>
        <a href="estoque.php?tipo=geral">Posição Geral</a> |
        <a href="estoque.php?tipo=baixo">Estoque Baixo</a> |
        <a href="estoque.php?tipo=excessivo">Estoque Excessivo</a>
    </nav>

    <hr>

    <h2><?= htmlspecialchars($titulo) ?></h2>

    <table border="1" cellpadding="8">

        <tr>
            <th>ID</th>
            <th>Produto</th>

            <?php if ($tipo == "geral") { ?>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Estoque Mínimo</th>
                <th>Estoque Máximo</th>
            <?php } ?>

            <th>Quantidade Atual</th>

            <?php if ($tipo == "baixo") { ?>
                <th>Estoque Mínimo</th>
            <?php } ?>

            <?php if ($tipo == "excessivo") { ?>
                <th>Estoque Máximo</th>
            <?php } ?>

            <th>Localização</th>
        </tr>

        <?php foreach ($produtos as $p) { ?>

            <tr>

                <td><?= $p["id"] ?></td>

                <td><?= htmlspecialchars($p["nome"]) ?></td>

                <?php if ($tipo == "geral") { ?>
                    <td><?= htmlspecialchars($p["categoria"]) ?></td>
                    <td>R$ <?= number_format($p["preco"], 2, ",", ".") ?></td>
                    <td><?= $p["estoque_minimo"] ?></td>
                    <td><?= $p["estoque_maximo"] ?></td>
                <?php } ?>

                <td><?= $p["quantidade"] ?></td>

                <?php if ($tipo == "baixo") { ?>
                    <td><?= $p["estoque_minimo"] ?></td>
                <?php } ?>

                <?php if ($tipo == "excessivo") { ?>
                    <td><?= $p["estoque_maximo"] ?></td>
                <?php } ?>

                <td><?= htmlspecialchars($p["localizacao"]) ?></td>

            </tr>

        <?php } ?>

        <?php if (count($produtos) == 0) { ?>

            <tr>
                <td colspan="8">Nenhum produto encontrado neste relatório.</td>
            </tr>

        <?php } ?>

    </table>

    <br>

    <a href="../produtos/listar.php">Consultar produtos</a>

    <br><br>

    <a href="../movimentacoes/registrar.php">Registrar movimentação</a>

    <br><br>

    <a href="../movimentacoes/historico.php">Histórico de movimentações</a>

</body>
</html>