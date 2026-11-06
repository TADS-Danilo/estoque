<?php
header("Content-Type: text/html; charset=UTF-8");

require_once __DIR__ . "/../classes/Movimentacao.php";

$movimentacao = new Movimentacao();
$movimentacoes = $movimentacao->listar();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Histórico de Movimentações</title>
</head>

<body>
    <?php include __DIR__ . "/../includes/menu.php"; ?>
    <h1>Histórico de Movimentações</h1>

    <table border="1" cellpadding="8">

        <tr>
            <th>ID</th>
            <th>Produto</th>
            <th>Tipo</th>
            <th>Quantidade</th>
            <th>Data</th>
            <th>Observação</th>
        </tr>

        <?php foreach ($movimentacoes as $m) { ?>

            <tr>
                <td><?= $m["id"] ?></td>

                <td>
                    <?= htmlspecialchars($m["produto"]) ?>
                </td>

                <td>
                    <?= $m["tipo"] == "ENTRADA" ? "Entrada" : "Saída" ?>
                </td>

                <td><?= $m["quantidade"] ?></td>

                <td>
                    <?= date("d/m/Y H:i:s", strtotime($m["data_movimentacao"])) ?>
                </td>

                <td>
                    <?= htmlspecialchars($m["observacao"] ?? "") ?>
                </td>
            </tr>

        <?php } ?>

        <?php if (count($movimentacoes) == 0) { ?>

            <tr>
                <td colspan="6">Nenhuma movimentação registrada.</td>
            </tr>

        <?php } ?>

    </table>

    <br>

    <a href="registrar.php">Registrar nova movimentação</a>

    <br><br>

    <a href="../produtos/listar.php">Consultar produtos</a>

</body>
</html>