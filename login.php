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

        $error = "Incorrect username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="css/common.css">
</head>


<body>



    <div class="header">
        <a href="/pokedex/admin/dashboard.php">
            <img src='./assets/Firma.svg' alt='logo' class="firma" />
        </a>

    </div>
    <h1 class="formTitle">Welcome</h1>
    <div class="formulario">
        <form action="login.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
            <br>
            <?php if(isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <button type="submit" name="submit">Log in</button>
        </form>
    </div>

</body>
<?php include('footer.php'); ?>

</html>