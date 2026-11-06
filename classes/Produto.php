
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

    public function existe($nome) {

        $sql = "SELECT id FROM produto
                WHERE nome = :nome";

        $conexao = Conexao::conectar();

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":nome", $nome);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }

    public function cadastrar() {

        // Valida o nome
        if (empty(trim($this->nome))) {
            throw new Exception("O nome do produto é obrigatório.");
        }

        // Verifica se o produto já existe
        if ($this->existe($this->nome)) {
            throw new Exception("Já existe um produto com esse nome.");
        }

        // Valida a categoria
        if (empty($this->categoria_id)) {
            throw new Exception("Selecione uma categoria.");
        }

        // Valida a quantidade
        if ($this->quantidade < 0) {
            throw new Exception("A quantidade não pode ser negativa.");
        }

        // Valida o preço
        if ($this->preco < 0) {
            throw new Exception("O preço não pode ser negativo.");
        }

        // Valida a localização
        if (empty(trim($this->localizacao))) {
            throw new Exception("A localização é obrigatória.");
        }

        // Valida o estoque mínimo
        if ($this->estoque_minimo < 0) {
            throw new Exception("O estoque mínimo não pode ser negativo.");
        }

        // Valida o estoque máximo
        if ($this->estoque_maximo < $this->estoque_minimo) {
            throw new Exception("O estoque máximo deve ser maior ou igual ao estoque mínimo.");
        }

        // Verifica se a categoria existe
        $sql = "SELECT id FROM categoria WHERE id = :id";

        $conexao = Conexao::conectar();

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":id", $this->categoria_id);
        $stmt->execute();

        if (!$stmt->fetch()) {
            throw new Exception("A categoria selecionada não existe.");
        }

        // Cadastra o produto
        $sql = "INSERT INTO produto
                (nome, categoria_id, quantidade, preco,
                localizacao, estoque_minimo, estoque_maximo)
                VALUES
                (:nome, :categoria_id, :quantidade, :preco,
                :localizacao, :estoque_minimo, :estoque_maximo)";

        $stmt = $conexao->prepare($sql);

        $stmt->bindValue(":nome", trim($this->nome));
        $stmt->bindValue(":categoria_id", $this->categoria_id);
        $stmt->bindValue(":quantidade", $this->quantidade);
        $stmt->bindValue(":preco", $this->preco);
        $stmt->bindValue(":localizacao", trim($this->localizacao));
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
