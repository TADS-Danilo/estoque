
<?php

require_once __DIR__ . "/../config/Conexao.php";

class Produto {

    private $id;
    private $nome;
    private $categoria_id;
    private $quantidade;
    private $preco;
    private $localizacao;
    private $estoque_minimo;
    private $estoque_maximo;

    public function __construct(
        $nome = null,
        $categoria_id = null,
        $quantidade = 0,
        $preco = 0,
        $localizacao = null,
        $estoque_minimo = 5,
        $estoque_maximo = 100
    ) {
        $this->nome = $nome;
        $this->categoria_id = $categoria_id;
        $this->quantidade = $quantidade;
        $this->preco = $preco;
        $this->localizacao = $localizacao;
        $this->estoque_minimo = $estoque_minimo;
        $this->estoque_maximo = $estoque_maximo;
    }

    public function cadastrar() {

        $sql = "INSERT INTO produto
                (nome, categoria_id, quantidade, preco,
                 localizacao, estoque_minimo, estoque_maximo)
                VALUES
                (:nome, :categoria_id, :quantidade, :preco,
                 :localizacao, :estoque_minimo, :estoque_maximo)";

        $conexao = Conexao::conectar();

        $stmt = $conexao->prepare($sql);

        $stmt->bindValue(":nome", $this->nome);
        $stmt->bindValue(":categoria_id", $this->categoria_id);
        $stmt->bindValue(":quantidade", $this->quantidade);
        $stmt->bindValue(":preco", $this->preco);
        $stmt->bindValue(":localizacao", $this->localizacao);
        $stmt->bindValue(":estoque_minimo", $this->estoque_minimo);
        $stmt->bindValue(":estoque_maximo", $this->estoque_maximo);

        return $stmt->execute();
    }

    public function listar() {

        $sql = "SELECT p.*, c.nome AS categoria
                FROM produto p
                INNER JOIN categoria c ON p.categoria_id = c.id
                ORDER BY p.nome";

        $conexao = Conexao::conectar();

        $stmt = $conexao->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function consultarPorNome($nome) {

        $sql = "SELECT p.*, c.nome AS categoria
                FROM produto p
                INNER JOIN categoria c ON p.categoria_id = c.id
                WHERE p.nome LIKE :nome
                ORDER BY p.nome";

        $conexao = Conexao::conectar();

        $stmt = $conexao->prepare($sql);

        $stmt->bindValue(":nome", "%" . $nome . "%");

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function consultarPorLocalizacao($localizacao) {

        $sql = "SELECT p.*, c.nome AS categoria
                FROM produto p
                INNER JOIN categoria c ON p.categoria_id = c.id
                WHERE p.localizacao LIKE :localizacao
                ORDER BY p.nome";

        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($sql);

        $stmt->bindValue(":localizacao", "%" . $localizacao . "%");

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
