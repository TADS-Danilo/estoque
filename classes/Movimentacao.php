
<?php

require_once __DIR__ . "/../config/Conexao.php";

class Movimentacao {

    // Atributos
    private $id;
    private $produto_id;
    private $tipo;
    private $quantidade;
    private $data_movimentacao;
    private $observacao;

    // Construtor
    public function __construct(
        $produto_id = null,
        $tipo = null,
        $quantidade = null,
        $observacao = null,
        $id = null,
        $data_movimentacao = null
    ) {
        $this->id = $id;
        $this->produto_id = $produto_id;
        $this->tipo = $tipo;
        $this->quantidade = $quantidade;
        $this->data_movimentacao = $data_movimentacao;
        $this->observacao = $observacao;
    }

    // Registra uma movimentação e atualiza o estoque
    public function registrar() {

        if ($this->quantidade <= 0) {
            throw new Exception("A quantidade deve ser maior que zero.");
        }

        if ($this->tipo != "ENTRADA" && $this->tipo != "SAIDA") {
            throw new Exception("Tipo de movimentação inválido.");
        }

        $conexao = Conexao::conectar();

        try {

            // Inicia a transação
            $conexao->beginTransaction();

            // Consulta o estoque atual do produto
            $sql = "SELECT quantidade
                    FROM produto
                    WHERE id = :id
                    FOR UPDATE";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(":id", $this->produto_id);
            $stmt->execute();

            $produto = $stmt->fetch();

            if (!$produto) {
                throw new Exception("Produto não encontrado.");
            }

            $estoque_atual = $produto["quantidade"];

            // Calcula o novo estoque
            if ($this->tipo == "ENTRADA") {

                $novo_estoque = $estoque_atual + $this->quantidade;

            } else {

                if ($this->quantidade > $estoque_atual) {
                    throw new Exception("Estoque insuficiente para realizar a saída.");
                }

                $novo_estoque = $estoque_atual - $this->quantidade;
            }

            // Atualiza a quantidade do produto
            $sql = "UPDATE produto
                    SET quantidade = :quantidade
                    WHERE id = :id";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(":quantidade", $novo_estoque);
            $stmt->bindValue(":id", $this->produto_id);
            $stmt->execute();

            // Registra a movimentação no histórico
            $sql = "INSERT INTO movimentacao
                    (produto_id, tipo, quantidade, observacao)
                    VALUES
                    (:produto_id, :tipo, :quantidade, :observacao)";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(":produto_id", $this->produto_id);
            $stmt->bindValue(":tipo", $this->tipo);
            $stmt->bindValue(":quantidade", $this->quantidade);
            $stmt->bindValue(":observacao", $this->observacao);
            $stmt->execute();

            // Confirma as operações
            $conexao->commit();

            return true;

        } catch (Exception $e) {

            // Desfaz as operações em caso de erro
            if ($conexao->inTransaction()) {
                $conexao->rollBack();
            }

            throw $e;
        }
    }

    // Consulta todas as movimentações
    public function listar() {

        $sql = "SELECT
                    m.id,
                    p.nome AS produto,
                    m.tipo,
                    m.quantidade,
                    m.data_movimentacao,
                    m.observacao
                FROM movimentacao m
                INNER JOIN produto p
                    ON m.produto_id = p.id
                ORDER BY m.data_movimentacao DESC, m.id DESC";

        $conexao = Conexao::conectar();

        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
