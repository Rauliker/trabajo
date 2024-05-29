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

    if (isset($_SESSION['admin'])) {
        $rrr = $admin->insertar($_SESSION['tabla']);
    } else {
        header('Location: administrar');
    }

    ?>
</body>

</html>