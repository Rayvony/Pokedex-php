<?php
session_start();

include 'includes/db.php';

if(isset($_SESSION['admin_id'])) {
    header("Location: /pokedex/admin/dashboard.php");
    exit();
}

if(isset($_POST['submit'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // sql injection prevention (let's fucking go)
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    $sql = "SELECT 1 FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);


    if($result->num_rows > 0) {

        $_SESSION['admin_id'] = 1;
        header("Location: /pokedex/admin/dashboard.php");
        exit();
    } else {

        $error = "Nombre de usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <h1>Iniciar sesión</h1>

    <?php if(isset($error)): ?>
    <p><?php echo $error; ?></p>
    <?php endif; ?>


    <form action="login.php" method="post">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit" name="submit">Iniciar sesión</button>
    </form>

</body>

</html>