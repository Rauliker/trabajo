<?php
class Database {
    private $host="localhost";
    private $username="iestacio";
    private $password="iestacio";
    private $database="tabla_proyec";
    public $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Error de conexión: " . $this->connection->connect_error);
        }

        // Establecer el juego de caracteres a UTF-8
        $this->connection->query("SET NAMES 'utf8'");
    }

    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}