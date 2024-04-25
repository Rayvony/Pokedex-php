<?php
require_once('includes/db.php');
require_once('includes/functions.php');

session_start();


$pokemon = null;


if(isset($_GET['search'])) {

    $searchTerm = strtolower($_GET['search']);


    $sql = "SELECT * FROM pokemon WHERE LOWER(name) = '$searchTerm'";
    $result = $conn->query($sql);


    if($result->num_rows > 0) {

        $pokemon = $result->fetch_assoc();
    } else {

        header("Location: index.php?error=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de búsqueda</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <?php include('header.php'); ?>

    <div class="pokemon_container">
        <?php if($pokemon): ?>
        <a
            href="pokemon.php?id=<?php echo $pokemon['id']; ?>">
            <div class="card">
                <h3 class="pkmn_name">
                    <?php echo $pokemon['name']; ?>
                </h3>
                <img
                    src=<?php echo $pokemon['image']; ?>
                class="pkmn_sprite"
                alt="<?php echo $pokemon['name']; ?>">
            </div>
        </a>
        <?php endif; ?>
    </div>

</body>
<?php include('footer.php'); ?>

</html>