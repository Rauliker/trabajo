<?php
require_once('class.database.php');
class vender
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function añadir()
    {

        $name = $_POST['name'];
        $descrip = $_POST['descrip'];
        $tipo = $_POST['tipo'];
        $direccion = $_POST['direccion'];
        $provincia = $_POST['provincias'];
        $municipios = $_POST['municipios'];
        $prec = $_POST['prec'];
        $nhab = $_POST['nhab'];
        $construccion = $_POST['construccion'];
        $estado = $_POST['estado'];
        $superficie = $_POST['superficie'];
        $pro = $this->bus("provincias", $_POST['provincias']);
        $mun = $this->bus("municipios", $_POST['municipios']);
        $user = $_SESSION['usuario'];

        $enlace = $name . "-" . $pro . "-" . $mun;

        $sql = "SELECT * FROM vivienda WHERE enlace ='" . $enlace . "'";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $ver = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($ver as $key => $value) {
            if ($enlace == $value['enlace']) {
                $enlace = $name . "-" . $pro . "-" . $mun . "-" . $value['id'];
            }
        }

        $visible = 1;
        $sql = "INSERT INTO vivienda(id, nombre, descrippcion, tipo, provincia, municiopio, direccion, precio, habitaciones, superficie, construccion, estado, visible, enlace ,user) VALUES (NULL, '$name', '$descrip', '$tipo', '$provincia', '$municipios', '$direccion', $prec, $nhab, $superficie, '$construccion', '$estado', $visible, '$enlace' ,'$user');";
        $stmt = $this->db->connection->prepare($sql);

        //$stmt->bind_param("ssssssi", $id, $name, $lastname, $passw, $email, $tel, $visible);
        $result = $stmt->execute();
        $id = $this->db->connection->insert_id;

        if ($result) {
            echo "Vivienda añadida correctamente";
            // Iniciamos la sesión y guardamos el valor
            echo "<br>";
        } else {
            echo "Error al crear el usuario: " . $this->db->connection->error;
        }
        // Verifica si se envió el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            if (isset($_FILES["img"])) {

                for ($i = 0; $i < count($_FILES["img"]["name"]); $i++) {
                    $file = $_FILES["img"];
                    $file_name = $file["name"][$i];

                    $file_type = $file["type"][$i];
                    if ("image/png" == $file_type) {
                        $a = $i . ".png";
                    } else {
                        $a = $i . ".jpg";
                    }

                    $file_size = $file["size"][$i];
                    $file_tmp_name = $file["tmp_name"][$i];
                    $file_error = $file["error"][$i];

                    if ($file_error === UPLOAD_ERR_OK) {
                        $target_dir = "images/" . $id . "/";

                        if (!file_exists($target_dir)) {
                            mkdir($target_dir, 0777, true);
                        }

                        move_uploaded_file($file_tmp_name, $target_dir . $a);

                        move_uploaded_file($file_tmp_name, "images/" . $id . "/" . $a);
                        $file_direc = $id . "/" . $a;

                        $stmt = $this->db->connection->prepare("INSERT INTO imagen(imagen, id_vivienda,enlace) VALUES (?, ?, ?)");
                        $stmt->bind_param("sds", $file_direc, $id, $enlace);
                        $result = $stmt->execute();

                        if (!$result) {
                            echo "Error al crear la imagen: " . $this->db->connection->error;
                        }
                    } else {
                        echo "Error al subir el archivo. Código de error: " . $file_error;
                    }
                }
            } else {
                echo "No se recibió ningún archivo.";
            }
        }
    }

    public function table($name)
    {
        $sql = "SELECT * FROM $name";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $propertyTypes = $result->fetch_all(MYSQLI_ASSOC);
        echo "<label>$name:</label>
            <br>
            <select type='input' id='$name' name='$name' placeholder='Property Type' required>
            ";
        if ($name == "municipios") {
            foreach ($propertyTypes as $propertyType) {
                if (is_array($propertyType) && array_key_exists("id", $propertyType)) {
                    echo "<option value='" . $propertyType['id'] . "' name='" . $propertyType['id_provincia'] . "'>" . $propertyType['nombre'] . "</option>";
                }
            }
        } else if ($name == "tipo") {
            foreach ($propertyTypes as $propertyType) {
                if (is_array($propertyType) && array_key_exists("id", $propertyType)) {
                    echo "<option value='" . $propertyType['nombre'] . "'>" . $propertyType['nombre'] . "</option>";
                }
            }
        } else {
            foreach ($propertyTypes as $propertyType) {
                if (is_array($propertyType) && array_key_exists("id", $propertyType)) {
                    echo "<option value='" . $propertyType['id'] . "'>" . $propertyType['nombre'] . "</option>";
                }
            }
        }

        echo "</select>
        <br>";
    }

    public function buscar()
    {
        $sql = "SELECT * FROM provincias";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $provincias = $result->fetch_all(MYSQLI_ASSOC);

        $json = json_encode($provincias);
        file_put_contents('assets/js/provincias.json', $json);
    }

    public function bus($bbb, $aaa)
    {
        $sql = "SELECT nombre FROM $bbb WHERE id = $aaa";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_row();
        foreach ($fila as $key => $value) {
            return ($value);
        }
    }
}
