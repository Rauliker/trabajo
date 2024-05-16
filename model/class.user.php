<?php
require_once('class.database.php');

class user {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function añadir() {
        // Comprobamos que both variables have been sent
        if (isset($_POST['user_id']) && isset($_POST['user_name']) && isset($_POST['user_lastname']) && isset($_POST['passw']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['passw_val'])) {
            
            $id = $_POST['user_id'];
            $name = $_POST['user_name'];
            $lastname = $_POST['user_lastname'];
            $passw = $_POST['passw'];
            $email = $_POST['email'];
            $tel = $_POST['tel'];
            $passw_val = $_POST['passw_val'];
            
            if ($passw!=$passw_val) {
                echo "Las contraseñas no coinciden.";
            } else {
                // Consulta para comprobar si el usuario ya existe
                $sql1 = "SELECT * FROM user WHERE user_id = '$id' OR  email='$email'";
                $stmt = $this->db->connection->prepare($sql1);
                //$stmt->bind_param("ss", $id, $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $users = $result->fetch_all(MYSQLI_ASSOC);
        
                // Si no existe el usuario, lo insertamos
                
                if (empty($users)) {
                    foreach ($users as $key => $value) {
                        echo $value;
                    }
                    
                    $visible = 1;
                    $sql = "INSERT INTO user(user_id, name, lastname, password, email, tel, visible) VALUES ('$id', '$name', '$lastname', '$passw', '$email', '$tel', $visible);";
                    $stmt = $this->db->connection->prepare($sql);
                    
                    //$stmt->bind_param("ssssssi", $id, $name, $lastname, $passw, $email, $tel, $visible);
                    $result = $stmt->execute();
        
                    if ($result) {
                        echo "Usuario creado correctamente";
                        // Iniciamos la sesión y guardamos el valor
                        $_SESSION["usuario"] = true;
                        echo "a";
                    } else {
                        echo "Error al crear el usuario: " . $this->db->connection->error;
                    }
                } else {
                    echo "Usuario ya existente";
                }
            }
            
        } else {
            echo "Faltan parámetros";
        }
    }

    public function ver_user() {
        $sql = "SELECT * FROM user;";

        $result = $this->db->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
        
    }

    public function acceder() {
        if (isset($_POST['user_id']) && isset($_POST['passw']) && isset($_POST['email'])) {
            $id = $_POST['user_id'];
            $passw = $_POST['passw'];
            $email = $_POST['email'];
    
            // Consulta para comprobar si el usuario ya existe
            $sql1 = "SELECT * FROM user WHERE user_id = '". $id ."' AND email = '". $email ."' AND  visible=1;";
            $stmt = $this->db->connection->prepare($sql1);
            //$stmt->bind_param("ss", $id, $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $users = $result->fetch_all(MYSQLI_ASSOC);
    
            // Si el usuario existe, lo iniciamos y guardamos el valor
            if (!empty($users)) {
                // Verificamos si la contraseña es correcta
                if ($users[0]['password'] == $passw) {
                    // Iniciamos la sesión y guardamos el valor
                    $_SESSION["usuario"] = true;
                    foreach ($users as $key => $value) {
                        echo "Bienvenido " . $value['user_id'];
                    }
                } else {
                    echo "Contraseña incorrecta";
                }
            } else {
                echo "Usuario no existente";
            }
        } else {
            echo "Faltan parámetros";
        }
    }
}
?>