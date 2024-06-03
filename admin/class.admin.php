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
        echo "<a href='administrar'>atras</a>";
        echo "<form method='get'>
        &nbsp;<button name='botonI' value='Insert'>Insertar</button></br>";

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
            &nbsp;<button name='botonB' value='" . $ad . "'>Borrar</button><br>";
        }
        if (isset($_GET['botonC'])) {
            ob_clean();
            $this->Cambiar($a, $_GET['botonC']);
        } elseif (isset($_GET['botonI'])) {
            ob_clean();
            $this->insertar($a);
        } elseif (isset($_GET['botonB'])) {
            $this->borrar($a, $_GET['botonB']);
        }
        echo "<from>";
    }
    public function borrar($a, $b)
    {
        try {
            $conexion = $this->db->connection;
            $sql = "SELECT * FROM $a";
            $result = $conexion->query($sql);
            $i = 0;
            $idname = "";
            $updatedData = [];
            foreach ($result as $values) {
                foreach ($values as $key => $fila) {
                    if ($i == 0) {
                        $i++;
                        $idname = $key;
                    }
                    $updatedData[$key] = '';
                }
                break;
            }
            $conexion = $this->db->connection;
            $sql = "DELETE FROM $a WHERE $idname = '$b'";
            $conexion->query($sql);
            header('Location: tabla');
            echo "delete correcto";
            exit;
        } catch (\Throwable $th) {
            echo "<p>Hubo un error al ejecutar la sentencia de delete: ";
            echo "{$conexion->error}</p>";
        }
    }
    public function insertar($a)
    {
        $conexion = $this->db->connection;
        $sql = "SELECT * FROM $a";
        $result = $conexion->query($sql);
        $i = 0;
        $idname = "";
        $id = "";
        $updatedData = [];

        echo "<form method='post'>";
        foreach ($result as $values) {
            foreach ($values as $key => $fila) {
                echo "<label>" . $key . "</label></br>";
                if ($key == "visible") {
                    echo "<input type='number' name='" . $key . "' min='0' max='1'></br>";
                } else {
                    echo "<input type='text' name='" . $key . "' required></br>";
                }

                if ($i == 0) {
                    $i++;
                    $id = $fila;
                    $idname = $key;
                }
                $updatedData[$key] = '';
            }
            break;
        }
        echo '<input type="submit" name="baceptar" value="aceptar">';
        echo "<a href='tabla'>atras</a>";
        echo "</form>";
        $x = 0;
        if (isset($_POST['baceptar'])) {
            try {
                $sql = "INSERT INTO $a SET ";
                foreach ($updatedData as $key => $value) {
                    if ($x != 0) {
                        $sql .= ", $key = '" . $_POST[$key] . "' ";
                    } else {
                        $x++;
                        $sql .= "$key = '" . $_POST[$key] . "' ";
                    }
                }
                $conexion->query($sql);
                echo "registro insertado";
            } catch (\Throwable $th) {
                echo "<p>Hubo un error al ejecutar la sentencia de inserción: ";
                echo "{$conexion->error}</p>";
            }
        }
    }
    public function Cambiar($a, $b)
    {
        $conexion = $this->db->connection;
        $sql = "SELECT * FROM $a ";
        $result = $conexion->query($sql);
        $i = 0;
        $idname = "";
        $id = "";
        $updatedData = [];
        echo "<form method='post'>";
        foreach ($result as $values) {
            foreach ($values as $key => $fila) {
                if ($i == 0) {
                    $i++;
                    $idname = $key;
                }
            }
            break;
        }
        $sql = "SELECT * FROM $a WHERE $idname='$b'";
        $result = $conexion->query($sql);
        $i = 0;
        foreach ($result as $values) {
            foreach ($values as $key => $fila) {
                echo "<label>" . $key . "</label></br>";
                if ($key == "visible") {
                    echo "<input type='number' name='" . $key . "' value='" . $fila . "' min='0' max='1' ></br>";
                } else {
                    echo "<input type='text' name='" . $key . "' value='" . $fila . "' required></br>";
                }
                if ($i == 0) {
                    $i++;
                    $id = $fila;
                    $idname = $key;
                }

                $updatedData[$key] = $fila;
            }
            break;
        }


        echo '<input type="submit" name="baceptar" value="aceptar">';
        echo "<a href='tabla'>atras</a>";
        echo "</form>";
        $x = 0;
        if (isset($_POST['baceptar'])) {
            try {
                $sql = "UPDATE $a SET ";
                foreach ($updatedData as $key => $value) {
                    if ($x != 0) {
                        $sql .= ", $key = '" . $_POST[$key] . "' ";
                    } else {
                        $x++;
                        $sql .= "$key = '" . $_POST[$key] . "' ";
                    }
                }
                $sql .= " WHERE $idname  = '$id'";
                $conexion->query($sql);
                echo "fila editada";
            } catch (\Throwable $th) {
                echo "<p>Hubo un error al ejecutar la sentencia de inserción: ";
                echo "{$conexion->error}</p>";
            }
        }
    }
}
