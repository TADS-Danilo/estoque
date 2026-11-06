create database gerenciamento_estoque;
use gerenciamento_estoque;

SET GLOBAL validate_password.policy = 0;
SET GLOBAL validate_password.length = 6;
CREATE USER 'estoque'@'%' IDENTIFIED BY '123456';
GRANT ALL ON gerenciamento_estoque.* TO 'estoque'@'%';

CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    categoria_id INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 0,
    preco DECIMAL(10,2) NOT NULL,
    localizacao VARCHAR(100) NOT NULL,
    estoque_minimo INT NOT NULL DEFAULT 5,
    estoque_maximo INT NOT NULL DEFAULT 100,
    FOREIGN KEY (categoria_id) REFERENCES categoria(id)
);

CREATE TABLE movimentacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tipo ENUM('ENTRADA', 'SAIDA') NOT NULL,
    quantidade INT NOT NULL,
    data_movimentacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    observacao VARCHAR(255),
    FOREIGN KEY (produto_id) REFERENCES produto(id)
);