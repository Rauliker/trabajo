<?php
include('model/class.vender.php');
$vend = new vender();
echo '<form method="post" enctype="multipart/form-data">
<br>
<label>Name:</label>
<br>
<input type="text" name="name" placeholder="Nombre de la vivienda" required>
<br>
<label>Descripcion:</label>
<br>
<input type="text" name="descrip" placeholder="Descripcion">
<br>
';
$vender = $vend->table("tipo");
$vender = $vend->table("provincias");
$vender = $vend->table("municipios");
$vender = $vend->table("construccion");
$vender = $vend->table("estado");
$vender = $vend->buscar();
echo'
<label>Direccion:</label>
<br>
<input type="text" name="direccion" placeholder="Direccion" required>
<br>
<label>Numero de habitaciones:</label>
<br>
<input type="number" min="0" name="nhab" placeholder="numero de habitaciones" required>
<br>
<label>Precio en euros:</label>
<br>
<input type="number" min="0" name="prec" placeholder="Precio en euros" required>
<br>
<label>Superficie:</label>
<br>
<input type="number" min="0" name="superficie" placeholder="Superficie" required>
<br>
<label>Imagen:</label>
<br>
<input type="file" name="img[]" id="img" multiple accept="image/*" required>
<br>
<input type="submit" name="submit" value="Añadir" class="menu-item">
</form>';
?>