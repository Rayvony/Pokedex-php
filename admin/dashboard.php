<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: /pokedex/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <h1>Gad no?</h1>

    <form action="/pokedex/logout.php" method="post">
        <button type="submit" name="logout">Cerrar sesión</button>
    </form>


</body>

</html>