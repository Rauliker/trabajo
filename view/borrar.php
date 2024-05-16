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
        ?>
    </header>
    <main>
        <?php
        require_once("includes/filtros_borrar.php");
        if (isset($_POST['borrar'])) {
            require_once('model/class.borrar.php');
            $delete = new Borrar();
            $deleteV = $delete->borrarV($_POST['borrar']);
        }
        ?>
        <div id="cookieConsent" class="cookie-consent">
            <p>Este sitio web utiliza cookies para garantizar que obtenga la mejor experiencia en nuestro sitio web. <a href="politica_cookies" target="_blank">Más información</a></p>
            <button id="a">Aceptar</button>
            <button id="b">Rechazar</button>
        </div>

    </main>
    <script src="assets/js/cookies.js"></script>
</body>

</html>