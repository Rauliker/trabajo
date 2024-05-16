<?php
require_once('class.database.php');
require_once('model/class.inmuebles_categoria.php');
$inmuebles = new InmueblesCategoria();
class header
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function mostrar($url)
    {
        $inmuebles = new InmueblesCategoria();
        $inmuebles_lista = $inmuebles->listar();
        foreach ($inmuebles_lista as $key => $value) {
            if ($value['visible'] == 1 && $url != $value['nombre']) {
                echo "<button class='boton'><a href='" . $value['nombre'] . "' class='menu-item'>" . $value['nombre'] . "</a></button>";
            } else {
                echo '<button class="boton"><a href="home" class="menu-item" id="back">volver</a></button>';
            }
        }
        if ($url != "home") {
            echo '<form action="buscar" method="get">';
            echo '<input type="search" id="busqueda" name="busqueda" placeholder="Escribe algo para buscar" class="menu-item" required>';
            //echo '<input type="submit" id="Sbusqueda" value="Buscar" class="menu-item">';
            echo '</form>';
        }
        if ($url == 'login') {
            if (!empty($_SESSION)) {
                echo '<button class="boton"><a href="logout" class="menu-item" id="logout">cerrar sesion</a></button>';
            } else {
                echo '<button class="boton"><a href="home" class="menu-item" id="back">volver</a></button>';
            }
        } elseif ($_SESSION == true) {
            if ($url == 'login') {
                echo '<button class="boton"><a href="borrar" class="menu-item" id="borrar">borrar vivienda</a></button>';
                echo '<button class="boton"><a href="home" class="menu-item" id="back">volver</a></button>';
            } elseif ($url == 'sigin') {
                echo '<button class="boton"><a href="borrar" class="menu-item" id="borrar">borrar vivienda</a></button>';
                echo '<button class="boton"><a href="home" class="menu-item" id="back">volver</a></button>';
            } else {
                echo '<button class="boton"><a href="borrar" class="menu-item" id="borrar">borrar vivienda</a></button>';
                echo '<button class="boton"><a href="logout" class="menu-item" id="logout">cerrar sesion</a></button>';
            }
        } elseif ($url == 'sigin') {
            echo '<button class="boton"><a href="home" class="menu-item" id="back">volver</a></button>';
        } else {
            echo '<button class="boton"><a href="login" class="menu-item" id="regis">registrarse</a></button>';
            echo '<button class="boton"><a href="sigin" class="menu-item" id="login">iniciar sesion</a></button>';
        }
        echo '<button class="boton"><a href="financiar" class="menu-item" id="financiar">financiar</a></button>';
    }
}
