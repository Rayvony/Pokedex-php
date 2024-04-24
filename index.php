<?php
require_once('includes/db.php');
require_once('includes/functions.php');

session_start();


if (isset($_SESSION['admin_id'])) {
    header("Location: admin/dashboard.php");
    exit();
}

$sql = "SELECT * FROM pokemon";
$result = $conn->query($sql);


if(isset($_GET['error']) && $_GET['error'] == 1) {
    $errorMessage = "No se encontraron resultados.";
} else {
    $errorMessage = "";
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


    <h1>Pokédex</h1>

    <form action="search.php" method="get">
        <input type="text" name="search" placeholder="Search Pokémon by name">
        <button type="submit">Search</button>
    </form>
    <button>
        <a href="login.php">Log in </a>
    </button>
    <?php if($errorMessage): ?>
    <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <div class="pokemon_container">
        <?php while ($row = $result->fetch_assoc()): ?>
        <a
            href="pokemon.php?id=<?php echo $row['id']; ?>">
            <div class="card">
                <h3 class="pkmn_name">
                    <?php echo $row['name']; ?>
                </h3>
                <img src="<?php echo $row['image']; ?>"
                    class="pkmn_sprite"
                    alt="<?php echo $row['name']; ?>">
            </div>
        </a>
        <?php endwhile; ?>
    </div>



</body>

</html>