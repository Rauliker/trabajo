<?php
require_once('model/class.user.php');

if ($url == 'login') {
    $action = 'login';

    echo '<form method="post">
            <input type="input" name="user_id" placeholder="Nombre de usuario" required>
            <br>
            <input type="input" name="user_name" placeholder="Pon tu nombre" required>
            <br>
            <input type="input" name="user_lastname" placeholder="Pon tu apellido" required>
            <br>
            <input type="input" name="email" placeholder="e-mail" required>
            <br>
            <input type="tel" name="tel" placeholder="000-00-00-00" pattern="[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{2}" minlength="9" maxlength="12" required>
            <br>
            <input type="password" name="passw" placeholder="Contraseña del usuario" required>
            <br>
            <input type="password" name="passw_val" placeholder="Repita la contraseña" required>
            <br>
            <input type="submit" value="Registrarse" class="menu-item">
        </form>';
} elseif ($url == 'sigin') {
    $action = 'sigin';

    echo '<form method="post">
            <input type="input" name="user_id" placeholder="Nombre de usuario" required>
            <br>
            <input type="email" name="email" placeholder="e-mail" required>
            <br>
            <input type="password" name="passw" placeholder="Contraseña del usuario" required>
            <br>
            <input type="submit" value="Iniciar sesion" class="menu-item">
        </form>';
}
