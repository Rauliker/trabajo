<?php
include('model/class.buscar.php');
include('model/class.vender.php');
$buscar = new buscar();
echo '
<div class="Fborrar">
    <form action="borrar" method="post">
        <label>Nombre ID:</label>
        <br>
        <input type="number" id="Iborrar" name="borrar" placeholder="Escribe el id de la vivienda a borrar" required>
        <br>
        <br>
        <input type="submit" name="filtros" value="Buscar" class="filtrar">
    </form>
    <br>
</div>';
