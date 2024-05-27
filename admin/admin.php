<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>adminisrar</title>
</head>

<body>

    <?php
    require_once("admin/class.admin.php");
    $admin = new admin();
    if (isset($_POST['password']) && isset($_POST['password']) && $_POST['password'] === "admin" && $_POST['password'] === "admin") {
        $verf = $admin->verificar();
    } else {
        $verf = $admin->formulario();
    }

    ?>
</body>

</html>