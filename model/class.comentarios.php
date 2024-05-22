<?php
require_once('class.database.php');

class coment
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function ver()
    {
        $enlace = $_GET['from'];

        $sql = "SELECT * FROM vivienda WHERE enlace ='" . $enlace . "'";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $ver = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($ver as $key => $value) {
            $idV = $value['id'];
            $idu = $value['user'];
            break;
        }
        $sql = "SELECT * FROM comentarios WHERE id_vivienda ='" . $idV . "' AND id_coment2 IS NULL order by id_coment";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $verc = $result->fetch_all(MYSQLI_ASSOC);

        $sql1 = "SELECT AVG(c.nEst) AS a, COUNT(*) AS b FROM comentarios AS c WHERE id_vivienda ='" . $idV . "' AND id_coment2 IS NULL";
        $stmt = $this->db->connection->prepare($sql1);
        $stmt->execute();
        $result = $stmt->get_result();
        $verTM = $result->fetch_all(MYSQLI_ASSOC);
        echo "comentarios:";
        foreach ($verTM as $key => $value3) {
            echo "<br/>";
            echo "Media de valoraciones: " . ceil($value3['a']) . " " . $value3['b'] . " opiniones";
            echo "<br/>";
        }

        foreach ($verc as $key => $value) {
            echo "<div>";
            $id = $value['id_user'];
            echo "nombre: " . $value['id_user'];
            echo "<br>";
            echo "Valoracion:" . $value['nEst'] . "/5";
            echo "<br>";
            echo $value['valoracion'];
            echo "<br>";
            if ($value['id_coment2'] === NULL) {
                $sql = "SELECT * FROM comentarios WHERE id_vivienda ='" . $idV . "' AND id_coment2 IS NOT NULL order by id_coment2";
                $stmt = $this->db->connection->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $verr = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($verr as $key => $values) {
                    echo $values['id_user'] . " responde: " . $id;
                    echo "<br>";
                    if ($idu != $values['id_user']) {
                        echo "Valoracion:" . $values['nEst'];
                        echo "<br>";
                    }
                    echo $values['valoracion'];
                    echo "<br>";
                }
            }
            if (isset($_SESSION['usuario'])) {
                if ($_SESSION['usuario'] == $idu) {
                    echo '<form method="post">
                    <label>reseña</label>
                    <br>
                    <input type="input" name="res">
                    <br>
                    <input type="input" value="' . $value['id_coment'] . '" name="ocult" class="ocult">
                    <input type="submit" value="enviar" name="submit" class="menu-item">
                </form>';
                }
            }
            echo "<br>";
        }
        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['usuario'] != $idu) {
                echo $_SESSION['usuario'] . " añade tu opinion";
                echo '<form method="post">
                <label>valoracion</label>
                <br>
                <select name="valoracion" id="valoracion">
                    <option value="1" name="1">1
                    <option value="2" name="2">2
                    <option value="3" name="3">3
                    <option value="4" name="4">4
                    <option value="5" name="5">5
                </select>
            
                <br>
                <label>reseña</label>
                <br>
                <input type="input" name="res">
                <br>
                <input type="submit" value="comentar" name="submit" class="menu-item">
            </form>';
            }
        }
    }
    public function crear()
    {
        $enlace = $_GET['from'];

        $sql = "SELECT * FROM vivienda WHERE enlace ='" . $enlace . "'";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $ver = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($ver as $key => $value) {
            $idV = $value['id'];
            $idu = $value['user'];
            break;
        }

        if (isset($_SESSION['usuario'])) {
            if ($_SESSION['usuario'] == $idu) {
                echo "1";
                $sql = "SELECT * FROM comentarios WHERE id_vivienda ='" . $idV . "' AND id_user ='" . $_SESSION['usuario'] . "'";
                $stmt = $this->db->connection->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $ver = $result->fetch_all(MYSQLI_ASSOC);
                $ids = "NULL";
                foreach ($ver as $key => $value) {
                    if (isset($value['id_user'])) {
                        $name = $value['id_user'];
                        $ids = $value['id_coment'];
                        //DELETE FROM `comentarios` WHERE `comentarios`.`id_coment` = 5
                        $sql = "DELETE FROM comentarios WHERE id_coment = ?";
                        $stmt = $this->db->connection->prepare($sql);
                        $stmt->bind_param("i", $ids);
                        $stmt->execute();
                    }
                }
                $res = $_POST['res'];
                $val = "NULL";
                $ocult = $_POST['ocult'];
                //INSERT INTO `comentarios` (`id_coment`, `id_vivienda`, `id_user`, `nEst`, `valoracion`, `id_coment2`) VALUES (NULL, '75', 'user2', '3', 'hhh\r\n', NULL);
                $sql1 = "INSERT INTO `comentarios` (`id_coment`, `id_vivienda`, `id_user`, `nEst`, `valoracion`, `id_coment2`)VALUES ($ids,$idV,'" . $_SESSION['usuario'] . "',$val,'$res', $ocult );";
                $stmt = $this->db->connection->prepare($sql1);

                $result = $stmt->execute();
                $id = $this->db->connection->insert_id;
            } elseif ($_SESSION['usuario'] != $idu) {

                $sql = "SELECT * FROM comentarios WHERE id_vivienda ='" . $idV . "' AND id_user ='" . $_SESSION['usuario'] . "'";
                $stmt = $this->db->connection->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                $ver = $result->fetch_all(MYSQLI_ASSOC);
                $ids = "NULL";
                foreach ($ver as $key => $value) {
                    if (isset($value['id_user'])) {
                        $name = $value['id_user'];
                        $ids = $value['id_coment'];
                        //DELETE FROM `comentarios` WHERE `comentarios`.`id_coment` = 5
                        $sql = "DELETE FROM comentarios WHERE id_coment = ?";
                        $stmt = $this->db->connection->prepare($sql);
                        $stmt->bind_param("i", $ids);
                        $stmt->execute();
                    }
                }
                $res = $_POST['res'];
                $val = $_POST['valoracion'];
                //INSERT INTO `comentarios` (`id_coment`, `id_vivienda`, `id_user`, `nEst`, `valoracion`, `id_coment2`) VALUES (NULL, '75', 'user2', '3', 'hhh\r\n', NULL);
                $sql1 = "INSERT INTO `comentarios` (`id_coment`, `id_vivienda`, `id_user`, `nEst`, `valoracion`, `id_coment2`)VALUES ($ids,$idV,'" . $_SESSION['usuario'] . "',$val,'$res', NULL );";
                $stmt = $this->db->connection->prepare($sql1);

                $result = $stmt->execute();
                $id = $this->db->connection->insert_id;
            }
        }
    }
}
