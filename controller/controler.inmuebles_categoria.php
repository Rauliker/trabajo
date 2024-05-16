<?php
	require_once("../model/class.inmuebles_categoria.php");
	$inmuebles = new InmueblesCategoria();
	$inmuebles_lista = $inmuebles->listar();
	require_once("../view/inmuebles_categoria.php");
    