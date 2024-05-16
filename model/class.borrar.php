<?php
require_once('class.database.php');

class Borrar
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function borrarV($a)
    {
        // Prevenir inyección de SQL utilizando consultas preparadas
        $sql = "SELECT * FROM vivienda WHERE id = ?";
        $stmt = $this->db->connection->prepare($sql);
        $stmt->bind_param("i", $a); // "i" indica que $a es un entero
        $stmt->execute();
        $result = $stmt->get_result();
        $busq = $result->fetch_assoc();

        if ($busq != null) {
            // Consulta preparada para eliminar imágenes
            $sql = "SELECT * FROM imagen WHERE id_vivienda = ?";
            $stmt = $this->db->connection->prepare($sql);
            $stmt->bind_param("i", $a);
            $stmt->execute();
            $result = $stmt->get_result();

            // Iterar sobre los resultados de la consulta de imágenes
            while ($row = $result->fetch_assoc()) {

                // Eliminar la imagen
                unlink("images/" . $row['imagen'] . "");
            }
            rmdir("images/" . $a);

            // Eliminar la entrada de la vivienda
            $sql = "DELETE FROM vivienda WHERE id = ?";
            $stmt = $this->db->connection->prepare($sql);
            $stmt->bind_param("i", $a);
            $stmt->execute();

            echo "Vivienda borrada correctamente";
        } else {
            echo "La vivienda no existe";
        }
    }
}
