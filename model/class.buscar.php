<?php
require_once('class.database.php');

class Buscar
{
    private $db;
    public $pagina;
    public $registros_por_pagina;

    public function __construct($pagina = 1, $registros_por_pagina = 5)
    {
        $this->pagina = (isset($_GET["pagina"])) ? (int) $_GET["pagina"] : 1;
        $this->registros_por_pagina = $registros_por_pagina;
        $this->db = new Database();
    }

    // Then use $this->registros_por_pagina in your methods wherever needed.


    public function busca()
    {

        $inicio = ($this->pagina - 1) * $this->registros_por_pagina;
        $buscar = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
        $registros_por = isset($_GET['registros_por_pagina']) ? $_GET['registros_por_pagina'] : '';
        $sql = "SELECT *,DATE_FORMAT(dia, '%Y-%m-%d') AS fecha FROM vivienda WHERE nombre LIKE '%{$buscar}%'";
        if (isset($_POST['tipo']) && $_POST["tipo"] != "todos") {
            $sql .= " AND tipo = '" . $_POST['tipo'] . "'";
        }
        if (isset($_POST['provincias']) && $_POST["provincias"] != "todos") {
            $sql .= " AND provincia = " . $_POST['provincias'] . "";
        }
        if (isset($_POST['municipios']) && $_POST["municipios"] != "todos") {
            $sql .= " AND municiopio = " . $_POST['municipios'] . "";
        }
        if (isset($_POST['construccion']) && $_POST["construccion"] != "todos") {
            $sql .= " AND construccion = " . $_POST['construccion'] . "";
        }
        if (isset($_POST['estado']) && $_POST["estado"] != "todos") {
            $sql .= " AND estado = " . $_POST['estado'] . "";
        }
        if (isset($_POST['nhab']) && $_POST["nhab"] != "") {
            $sql .= " AND habitaciones = " . $_POST['nhab'] . "";
        }
        if (isset($_POST['prec']) && $_POST["prec"] != "") {
            $sql .= " AND precio = " . $_POST['prec'] . "";
        }
        if (isset($_POST['superficie']) && $_POST["superficie"] != "") {
            $sql .= " AND superficie = " . $_POST['superficie'] . "";
        }
        if (isset($_POST['fecha']) && $_POST["fecha"] != "") {
            $sql .= " AND DATE_FORMAT(dia, '%Y-%m-%d') <= '" . $_POST['fecha'] . "'";
        }

        $sql .= " LIMIT $inicio, $this->registros_por_pagina";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $busq = $result->fetch_all(MYSQLI_ASSOC);
        ////

        if (!empty($busq)) {
            echo "<h2>Resultados encontrados: " . count($busq) . "</h2>";
            $json = json_encode($busq);
            file_put_contents('assets/js/result.json', $json);
            foreach ($busq as $key => $value) {

                $sql1 = "SELECT * FROM imagen WHERE id_vivienda = " . $value['id'] . "";
                $stmt1 = $this->db->connection->prepare($sql1);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                $img = $result1->fetch_all(MYSQLI_ASSOC);

                echo '<div class="listing">';
                echo "<div class='listing-image'>";
                if (count($img) > 1) {
                    echo '<div class="botonIzq" id="' . $value['id'] . '">';
                    echo '<';
                    echo '</div>';
                }
                echo '<div class="' . $value['id'] . '">';
                echo  '<a id=i' . $value['id'] . ' href="inmueble?from=' . $value['enlace'] . '">';
                echo "<img src='images/" . $img[0]["imagen"] . "' class='image' width='250px' height='180px'>";
                echo '</a>';
                echo '</div>';
                if (count($img) > 1) {
                    echo '<div class="botonDer" id="' . $value['id'] . '">';
                    echo '>';
                    echo '</div>';
                }

                echo '</div>';
                echo "<a class='listing-details' href='inmueble?from=" . $value['enlace'] . "'>";
                echo "<div class='listing-name'>";
                if (is_array($value) && array_key_exists("id", $value)) {
                    echo "Nombre: " . $value["nombre"] . "";
                }
                echo '</div>';
                echo "<div class='listing-price'>";
                if (is_array($value) && array_key_exists("id", $value)) {
                    echo "Precio: " . $value["precio"] . "€";
                }
                echo '</div>';
                echo "<div class='listing-address'>";
                $sql2 = "SELECT m.nombre AS mun, p.nombre AS prov
                            FROM municipios m 
                            INNER JOIN provincias p ON p.id = m.id_provincia
                            WHERE m.id = " . $value['municiopio'] . ";";
                $stmt2 = $this->db->connection->prepare($sql2);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $provincias = $result2->fetch_all(MYSQLI_ASSOC);
                foreach ($provincias as $a => $b) {
                    if (is_array($value) && array_key_exists("id", $value)) {
                        echo "Direccion: " . $b["prov"] . ", " . $b["mun"] . ", " . $value["direccion"] . "";
                    }
                }
                echo '</div>';
                echo "<div class='listing-description'>";
                if (is_array($value) && array_key_exists("id", $value)) {
                    echo "Descripccion: " . $value["descrippcion"] . "";
                }
                echo '</div>';
                echo '</div>';
                echo '</a>';
            }
            $this->paginar(1);
        } else {
            echo "<h1>No se ha encontrado nada</h1>";
        }
    }
    public function paginar($registros)
    {
        $pg = (isset($_GET["pagina"])) ? (int) $_GET["pagina"] : 1;



        $pg_anterior = $pg - 1;
        $pg_siguiente = $pg + 1;
        $buscar = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
        $sql4 = "SELECT COUNT(*) as total FROM vivienda WHERE nombre LIKE '%{$buscar}%'";
        if (isset($_POST['tipo']) && $_POST["tipo"] != "todos") {
            $sql4 .= " AND tipo = '" . $_POST['tipo'] . "'";
        }
        if (isset($_POST['provincias']) && $_POST["provincias"] != "todos") {
            $sql4 .= " AND provincia = " . $_POST['provincias'] . "";
        }
        if (isset($_POST['municipios']) && $_POST["municipios"] != "todos") {
            $sql4 .= " AND municiopio = " . $_POST['municipios'] . "";
        }
        if (isset($_POST['construccion']) && $_POST["construccion"] != "todos") {
            $sql4 .= " AND construccion = " . $_POST['construccion'] . "";
        }
        if (isset($_POST['estado']) && $_POST["estado"] != "todos") {
            $sql4 .= " AND estado = " . $_POST['estado'] . "";
        }
        if (isset($_POST['nhab']) && $_POST["nhab"] != "") {
            $sql4 .= " AND habitaciones = " . $_POST['nhab'] . "";
        }
        if (isset($_POST['prec']) && $_POST["prec"] != "") {
            $sql4 .= " AND precio = " . $_POST['prec'] . "";
        }
        if (isset($_POST['superficie']) && $_POST["superficie"] != "") {
            $sql4 .= " AND superficie = " . $_POST['superficie'] . "";
        }
        if (isset($_POST['fecha']) && $_POST["fecha"] != "") {
            $sql4 .= " AND DATE_FORMAT(dia, '%Y-%m-%d') <= '" . $_POST['fecha'] . "'";
        }

        $resultado = $this->db->connection->query($sql4);
        $fila = $resultado->fetch_assoc();
        $resultado = $this->db->connection->query($sql4);
        $fila = $resultado->fetch_assoc();

        $total_pg = ceil($fila['total'] / $this->registros_por_pagina);


        /*if ($pg != 1) {
            echo '<a href="?busqueda='.$buscar.'&pagina=' . $pg_anterior . '&registros_por_pagina=' . $this->registros_por_pagina . '">Anterior</a>' . '&nbsp;&nbsp;&nbsp;&nbsp;';
        } 

        if ($total_pg!=$pg) {
            echo '<a href="?busqueda='.$buscar.'&pagina=' . $pg_siguiente . '&registros_por_pagina=' . $this->registros_por_pagina . '">Siguiente</a>';
        }*/
        if ($total_pg != 1) {
            echo '<div class="paginate">';
            for ($i = 0; $i < $total_pg; $i++) {
                $a = $i;
                $a++;
                if ($a != $pg) {
                    echo '<a href="?busqueda=' . $buscar . '&pagina=' . $a . '&registros_por_pagina=' . $this->registros_por_pagina . '">' . $a . '</a> ';
                }
            }
        }


        echo '</div>';
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
        echo "<option value='todos' name='todos'>todos</option>";
        if ($name == "municipios") {
            foreach ($propertyTypes as $propertyType) {
                if (is_array($propertyType) && array_key_exists("id", $propertyType)) {
                    echo "<option value=" . $propertyType['id'] . " name='" . $propertyType['id_provincia'] . "'>" . $propertyType['nombre'] . "</option>";
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
                    echo "<option value=" . $propertyType['id'] . ">" . $propertyType['nombre'] . "</option>";
                }
            }
        }

        echo "</select>
        <br>";
    }
    public function crear()
    {
        $buscar = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
        $sql = "SELECT * FROM vivienda WHERE nombre LIKE '%{$buscar}%'";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $busq = $result->fetch_all(MYSQLI_ASSOC);
        $json = json_encode($busq);
        file_put_contents('assets/js/result.json', $json);

        $sql1 = "SELECT * FROM imagen";
        $stmt1 = $this->db->connection->prepare($sql1);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $img = $result1->fetch_all(MYSQLI_ASSOC);
        $json = json_encode($img);
        file_put_contents('assets/js/img.json', $json);

        $sql = "SELECT * FROM tipo";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $tipo = $result->fetch_all(MYSQLI_ASSOC);

        $json = json_encode($tipo);
        file_put_contents('assets/js/tipo.json', $json);
    }
    public function fecha()
    {
        $sql1 = "SELECT MIN(DATE_FORMAT(dia, '%Y-%m-%d')) AS fecha 
        FROM vivienda";
        $stmt1 = $this->db->connection->prepare($sql1);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $row = $result1->fetch_assoc();
        $date = $row['fecha'];
        echo '<label>Fecha de publicacion:</label>
        <br>
        <input type="date" id="fecha" name="fecha" value="' . $row['fecha'] . '" min="' . $row['fecha'] . '" max="' . date('Y-m-d') . '" />';
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
