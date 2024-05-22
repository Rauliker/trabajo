<form method="post">
    <label>reseña</label>
    <br>
    <input type="input" name="res">
    <br>
    <?php
    require_once('model/class.comentarios.php');
    $comp = new coment();
    //$ver = $comp->poner();
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

    ?>
    <input type="submit" value="enviar" name="submit" class="menu-item">
</form>