
<?php

class Conexao {

    private static $instancia = null;

    public static function conectar() {

        if (self::$instancia === null) {

            $host = "localhost";
            $banco = "gerenciamento_estoque";
            $usuario = "estoque";
            $senha = "123456";

            try {

                self::$instancia = new PDO(
                    "mysql:host=$host;dbname=$banco;charset=utf8mb4",
                    $usuario,
                    $senha
                );

                self::$instancia->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

                self::$instancia->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );

            } catch (PDOException $e) {

                die("Erro ao conectar ao banco de dados: " . $e->getMessage());

            }
        }

        return self::$instancia;
    }
}
