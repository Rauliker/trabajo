<?php
class admin
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function verificar()
    {
        if ($_GET['username'] == "admin" || $_GET['password'] == "admin") {
            echo "bienvenido admin";
        }
    }
}
