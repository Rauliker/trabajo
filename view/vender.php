<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <header>
        <?php
        require_once("includes/header.php");
        if (isset($_GET['busqueda'])) {
            require_once('model/class.buscar.php');
            $bus = new buscar();
            $buscar = $bus->busca();
        }
        ?>
    </header>
    <main>
        <div class="fvender">
            <?php
            require_once("includes/vender_form.php");
            if (isset($_POST['submit'])) {
                require_once('model/class.vender.php');
                $vender = new vender();
                $vender_añadir = $vender->añadir();
            }
            ?>
        </div>
        <div id="cookieConsent" class="cookie-consent">
            <p>Este sitio web utiliza cookies para garantizar que obtenga la mejor experiencia en nuestro sitio web. <a href="politica_cookies" target="_blank">Más información</a></p>
            <button id="a">Aceptar</button>
            <button id="b">Rechazar</button>
        </div>

    </main>
    <script src="assets/js/cookies.js"></script>
    <script src="assets/js/vender.js"></script>


</body>

</html>