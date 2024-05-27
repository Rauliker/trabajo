<?php
require_once('model/class.database.php');

class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function formulario()
    {
        echo '
        <form method="post">
            <label>Username:</label>
            <input type="text" id="username" name="username"><br><br>
            <label>Password:</label>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" name="Login" value="Login">
        </form>';
    }

    public function verificar()
    {
        if (isset($_POST['Login'])) {

            $_SESSION['admin'] = "admin";
            $conexion = $this->db->connection;

            if ($conexion->connect_errno) {
                echo "Error de conexión con la base de datos: " . $conexion->connect_errno;
                exit;
            }

            $sql = "SHOW TABLES;";
            $result = $conexion->query($sql);

            if ($result) {
                while ($fila = $result->fetch_row()) {
                    echo $fila[0] . "<br>";
                }
                $result->free();
            } else {
                echo "Error al consultar la base de datos: " . $conexion->error;
            }
        }
    }
}
