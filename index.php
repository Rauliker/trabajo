<?php
session_start();
// mostrar errors al servidor
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// analitzar la URL per determinar la ruta
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
// lògica per cridar al controlador i al mètode adequat segons la ruta
switch ($url) {
    case 'home':
        include_once('controller/controler.home.php');
        break;

    case 'login':
        include_once('controller/controler.login.php');
        break;

    case 'logout':
        include_once('controller/controler.logout.php');
        break;

    case 'sigin':
        include_once('controller/controler.sigin.php');
        break;

    case 'vender':
        include_once('controller/controler.vender.php');
        break;
    case 'buscar':
        include_once('controller/controler.busqueda.php');
        break;
    case 'inmueble':
        include_once('controller/controler.inmueble.php');
        break;

    case 'borrar':
        include_once('controller/controler.borrar.php');
        break;

    case 'politica_cookies':
        include_once('controller/controler.politica_cookies.php');
        break;
    case 'financiar':
        include_once('controller/controller.financiar.php');
        break;
    case 'administrador':
        include_once('controller/controller.loginAdmin.php');
        break;
    default:
        http_response_code(404);
        echo 'pàgina no trobada';
        break;
}
