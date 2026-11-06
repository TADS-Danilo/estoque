
<?php

require_once __DIR__ . "/../config/Conexao.php";

class Categoria {

    private $id;
    private $nome;

    public function __construct($nome = null) {
        $this->nome = $nome;
    }

    public function existe($nome) {

        $sql = "SELECT id FROM categoria
                WHERE nome = :nome";

        $conexao = Conexao::conectar();

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":nome", $nome);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }

    public function cadastrar() {

        if (empty(trim($this->nome))) {
            throw new Exception("O nome da categoria é obrigatório.");
        }

        if ($this->existe($this->nome)) {
            throw new Exception("Já existe uma categoria com esse nome.");
        }

        $sql = "INSERT INTO categoria (nome) VALUES (:nome)";

        $conexao = Conexao::conectar();

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":nome", $this->nome);

        return $stmt->execute();
    }

    public function listar() {

        $sql = "SELECT * FROM categoria ORDER BY nome";

        $conexao = Conexao::conectar();

        $stmt = $conexao->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }

}