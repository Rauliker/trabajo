<?php
require_once('model/class.database.php');

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
            $_SESSION['admin'] = "admin";
            include 'admin.php';
        }
    }
}
