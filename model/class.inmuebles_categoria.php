<?php
require_once('class.database.php');

class InmueblesCategoria {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function editar($id) {
        $sql = "SELECT * FROM imuebles_categorias WHERE id = '$id';";

        $result = $this->db->connection->query($sql);;
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function listar() {
        $sql = "SELECT * FROM imuebles_categorias ORDER BY id ASC;";

        $result = $this->db->connection->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
        
    }

    function insertar($datos){
        // $datos es un array cuyas keys son el nombre de la columnas de la tabla y los valores el valor a insertar para esa columna.
        $nombre=$this->db->real_escape_string($datos['nombre']);
        
        $sql = "INSERT INTO imuebles_categorias (id, nombre, descripcion, visible) VALUES (NULL, '$nombre', '1');";
        if ($this->db->connection->query($sql) === TRUE) {
            return $this->db->insert_id;    //...se ha insertado el registro con id insert_id
        } else {
            return 0;                       //...no se ha insertado ningún registro
        }
    }

    function modificar($datos, $id){
        // $datos es un array cuyas keys son el nombre de la columnas de la tabla y los valores el valor a insertar para esa columna.
        // $id es el valor del campo id de la tabla imuebles_tipo
        //$nombre=$this->db->real_escape_string($datos['nombre']);
        $nombre=$datos['nombre'];
        
        $sql = "UPDATE imuebles_categorias SET nombre = '$nombre' WHERE id = ''$id;";
        return ($this->db->connection->query($sql) === TRUE);       //...devuelve true o false si se ha actualizado con éxito
    }
}