<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login admin</title>
</head>

<body>
    <form method="post">
        <label>Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label>Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" name="Login" value="Login">
    </form>
    <?php
    require_once("admin/class.admin.php");
    $admin = new admin();
    if ($_GET['Login']) {
        $verf = $admin->verificar();
    }

    ?>
</body>

</html>