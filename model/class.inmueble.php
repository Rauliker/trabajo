<?php

require_once('class.database.php');

class inmue
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function ver($get)
    {
        $buscar = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
        $sql = "SELECT *, DATE_FORMAT(dia, '%Y-%m-%d') AS fecha FROM vivienda WHERE enlace ='$get'";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $ver = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($ver as $key => $value) {
            $this->imagen($get);
            echo "<div class='i-info'>";
            echo "<ul class='ul-info'>";
            echo "<li class='li-info'><h1>" . $value['nombre'] . "</h1></li>";

            $description = $value['descrippcion'];
            $truncatedDescription = $this->truncateText($description, 100);
            echo "<li class='li-info description' id='description-$key'>" . $truncatedDescription . " <br></li>";
            if (strlen($description) >= 100) {
                echo "<li class='li-info'> <a href='#' class='toggle-description' data-item='$key'>Ver más</a> </li>";
            }
            echo "<li class='li-info'>" . $value['tipo'] . "</li>";
            $this->buscar($value['provincia'], "provincias");
            $this->buscar($value['municiopio'], "municipios");
            echo "<li class='li-info'>" . $value['direccion'] . "</li>";
            echo "<li class='li-info'>" . $value['precio'] . "€ </li>";
            echo "<li class='li-info'>" . $value['habitaciones'] . "</li>";
            echo "<li class='li-info'>" . $value['fecha'] . "</li>";
            echo "<li class='li-info'>" . $value['superficie'] . "m2 </li>";
            $this->buscar($value['construccion'], "construccion");
            $this->buscar($value['construccion'], "estado");
            echo "</ul>";
            echo "</div>";
            break;
        }
    }

    public function imagen($c)
    {
        $sql = "SELECT * FROM imagen WHERE enlace = '$c'";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $b = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($b as $key => $values) {
            echo "<div class='i-img'>";
            echo "<img src='images/" . $values['imagen'] . "' class='image'><br>";
            echo "</div>";
            break;
        }
    }

    public function buscar($a, $tabla)
    {
        $sql = "SELECT * FROM $tabla WHERE id = $a";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $b = $result->fetch_assoc();
        echo "<li class='li-info'>" . $b['nombre'] . "</li>";
    }

    public function truncateText($text, $length)
    {
        $truncatedText = substr($text, 0, $length);
        return $truncatedText;
    }
}
