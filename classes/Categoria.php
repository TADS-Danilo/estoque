
<?php

require_once __DIR__ . "/../config/Conexao.php";

class Categoria {

    private $id;
    private $nome;

    public function __construct($nome = null) {
        $this->nome = $nome;
    }

    public function cadastrar() {

        $sql = "INSERT INTO categoria (nome)
                VALUES (:nome)";

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