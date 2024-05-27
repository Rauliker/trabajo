<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login admin</title>
</head>

<body>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
    </form>
    <?php
    require_once("admin/class.admin.php");
    $admin = new admin();
    $verf = $admin->verificar();
    ?>
</body>

</html>