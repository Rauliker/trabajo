<?php
echo $_SESSION['usuario'] . " añade tu opinion";
?>
<form method="post">
    <label>valoracion</label>
    <br>
    <select name="valoracion" id="valoracion">
        <option value="1" name="1">1
        <option value="2" name="2">2
        <option value="3" name="3">3
        <option value="4" name="4">4
        <option value="5" name="5">5
    </select>

    <br>
    <label>reseña</label>
    <br>
    <input type="input" name="res">
    <br>
    <input type="submit" value="comentar" name="submit" class="menu-item">
</form>