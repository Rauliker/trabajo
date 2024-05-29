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
    public function mostrar()
    {
        $conexion = $this->db->connection;

        if ($conexion->connect_errno) {
            echo "Error de conexión con la base de datos: " . $conexion->connect_errno;
            exit;
        }

        $sql = "SHOW TABLES;";
        $result = $conexion->query($sql);

        if ($result) {
            //echo '<form method="$_GET">';
            while ($fila = $result->fetch_row()) {
                echo "<a value='tabla' href='tabla'>" . $fila[0] . "</a><br>";
                $_SESSION['tabla'] = $fila[0];
            }
            //echo '</form>';
            $result->free();
        } else {
            echo "Error al consultar la base de datos: " . $conexion->error;
        }
    }
    public function tablas($a)
    {
        $conexion = $this->db->connection;
        $sql = "SELECT * FROM user";
        $result = $conexion->query($sql);
        echo "&nbsp;<a href='insertar'>Insertar</a></br>";
        while ($fila = $result->fetch_row()) {

            echo $fila[0] . "&nbsp;Cambiar&nbsp;borrar<br>";
        }
    }
    public function insertar($a)
    {
        $conexion = $this->db->connection;
        $sql = "SELECT * FROM user";
        $result = $conexion->query($sql);
        echo '<form method="get">';
        foreach ($result as $value) {
            foreach ($value as $key => $values) {
                echo $key . "</br>";
            }
            break;
        }
        echo '</from>';
    }
}
