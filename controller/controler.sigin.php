<?php
    require_once("view/login.php");
    if (isset( $_POST['user_id'] ) || isset( $_POST['passw'] )) {
        require_once('model\class.user.php');
        $user = new user();
    }
?>