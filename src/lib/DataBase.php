<?php

namespace Vidamrr\Notas\lib;

use PDO;
use PDOException;

class Database {
    private string $servername = "127.0.0.1";
    private string $username = "root";
    private string $password = ""; // tu contraseña aquí si tienes una
    private string $dbname = "diezproyectos";
    private ?PDO $connection = null;

    public function __construct() {
        try {
            $this->connection = new PDO("mysql:host={$this->servername};dbname={$this->dbname};charset=utf8mb4", 
                                         $this->username, 
                                         $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        }
    }

    public function connect(): ?PDO {
        return $this->connection;
    }
}
