<?php
include('model/class.user.php');
/*require_once('model/class.inmuebles_categoria.php');
    $inmuebles = new InmueblesCategoria();
	$inmuebles_lista = $inmuebles->listar();*/
    require_once('model/class.header.php');
    $inmuebles = new header();
     
    echo '<div class="menu">';
        echo '<a href="home"><img class="logo" src="assets/img/casa.png" class="menu-item" height="80" align="left"></a>';
        echo '<div class="menu-content">';
        
        $inmuebles_lista = $inmuebles->mostrar($url); 
        
        echo '</div>';
    echo '</div>';
?>