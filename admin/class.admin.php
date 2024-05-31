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
            echo '<form method="$_GET" action="tabla">';
            while ($fila = $result->fetch_row()) {
                echo "<button name='gtabla' value='" . $fila[0] . "' href='tabla'>" . $fila[0] . "</a><br>";
            }
            echo '</form>';
            $result->free();
        } else {
            echo "Error al consultar la base de datos: " . $conexion->error;
        }
    }
    public function tablas($a)
    {
        $conexion = $this->db->connection;
        $sql = "SELECT * FROM $a";
        $result = $conexion->query($sql);
        echo "<form method='get'>
        &nbsp;<a href='insertar'>Insertar</a></br>";

        foreach ($result as $values) {
            $i = 0;
            foreach ($values as $key => $fila) {
                if ($key != "visible") {
                    if ($i == 0) {
                        $ad = $fila;
                        $i++;
                    }
                    echo $fila . " &nbsp";
                }
            }
            echo "&nbsp;<button name='botonC' value='" . $ad . "'>Cambiar</button>
            &nbsp;<button name='botonB' value='Borrar'>Borrar</button><br>";
        }
        if (isset($_GET['botonC'])) {
            ob_clean();
            $this->Cambiar();
        }
        echo "<from>";
    }
    public function insertar($a)
    {
    }
    public function Cambiar()
    {
        $conexion = $this->db->connection;
        $sql = "SELECT * FROM user";
        $result = $conexion->query($sql);
        echo "<form method='post'>";
        foreach ($result as $values) {
            foreach ($values as $key => $fila) {
                echo "<label>" . $key . "</label></br>";
                echo "<input type='text' name='" . $key . "' value='" . $fila . "'></br>";
            }
            break;
        }
        echo '<input type="submit" name="baceptar" value="aceptar">';
        echo "<button name='brechazar' value='cancelar'>cancelar</button></br>";
        echo "</from>";
        if (isset($_POST['brechazar'])) {
            echo "aaaa";
            header('Location: tabla');
        } elseif (isset($_POST['baceptar'])) {
            $sql = "UPDATE provincias SET nombre = 'Araba/Álava' WHERE provincias.id = 1;
            ";
        }
    }
}
