<?php
    if (!empty($_SESSION)) {
        require_once("view/vender.php");
    } else {
        header('Location: home');
    }
?>