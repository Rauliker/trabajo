<?php
include('model/class.buscar.php');
include('model/class.vender.php');
$buscar = new buscar();
echo '<button id="filtr" class="filtr" name="filtr" ">filtros</button>';
echo '<div class="filt" id="filt">
    <form method="post" >';
    $tipo = $buscar->table("tipo");
    $prov = $buscar->table("provincias");
    $mun = $buscar->table("municipios");
    $construccion = $buscar->table("construccion");
    $estado = $buscar->table("estado");
    echo'
    <label>Numero de habitaciones:</label>
    <br>
    <input type="number" min="0" id="nhab" name="nhab" placeholder="numero de habitaciones" >
    <br>
    <label>Precio en euros:</label>
    <br>
    <input type="number" min="0" id="prec" name="prec" placeholder="Precio en euros" >
    <br>
    <label>Superficie:</label>
    <br>
    <input type="number" min="0" id="superficie" name="superficie" placeholder="Superficie" >
    <br>
    ';
    $fecha=$buscar->fecha();
    $a=$buscar->crear();
    echo'
    <br>
    <br>
    <input type="submit" name="filtros" value="Buscar" class="filtrar">
    </form>
    <br>
</div>';
?>