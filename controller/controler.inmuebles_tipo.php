<?php
	require_once("../model/class.inmuebles_tipo.php");
	$inmuebles = new InmueblesTipo();
	$inmuebles_lista = $inmuebles->listar();
	require_once("../view/inmuebles_tipo.php");
    