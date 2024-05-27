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

    public function verificar()
    {
        if (isset($_POST['Login'])) {

            $_SESSION['admin'] = "admin";
            $sql = "SHOW TABLES;";
            $result = $this->db->connection->query($sql);
            if ($result) {
                foreach ($result as $key => $value) {
                    $value;
                }
            } else {
                echo "Error al consultar la base de datos";
            }
        }
    }
}
