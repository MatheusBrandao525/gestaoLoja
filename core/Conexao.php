<?php
class Conexao
{
    private static $instance = null;
    private $conn;
    private $servidor = "localhost";
    private $usuario = "root";
    private $senha = "1exagon1@";
    private $dbname = "topmotos";

    private function __construct()
    {
        try {
            // Atualize esta linha para usar PDO
            $dsn = "mysql:host=$this->servidor;port=3307;dbname=$this->dbname;charset=utf8";
            $this->conn = new PDO($dsn, $this->usuario, $this->senha, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Conexao();
        }
        return self::$instance;
    }

    public function getConexao()
    {
        return $this->conn;
    }
}
