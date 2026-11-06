<?php

require_once __DIR__ . "/../config/Conexao.php";

class Relatorio {

    // Retorna todos os produtos e suas categorias
    public function posicaoEstoque() {

        $sql = "SELECT
                    p.id,
                    p.nome,
                    c.nome AS categoria,
                    p.quantidade,
                    p.preco,
                    p.localizacao,
                    p.estoque_minimo,
                    p.estoque_maximo
                FROM produto p
                INNER JOIN categoria c ON p.categoria_id = c.id
                ORDER BY p.nome";

        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Retorna produtos com estoque baixo
    public function estoqueBaixo() {

        $sql = "SELECT
                    p.id,
                    p.nome,
                    p.quantidade,
                    p.estoque_minimo,
                    p.localizacao
                FROM produto p
                WHERE p.quantidade <= p.estoque_minimo
                ORDER BY p.quantidade";

        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Retorna produtos acima do estoque máximo
    public function estoqueExcessivo() {

        $sql = "SELECT
                    p.id,
                    p.nome,
                    p.quantidade,
                    p.estoque_maximo,
                    p.localizacao
                FROM produto p
                WHERE p.quantidade > p.estoque_maximo
                ORDER BY p.quantidade DESC";

        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}