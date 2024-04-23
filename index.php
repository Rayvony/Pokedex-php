<?php
require_once('includes/db.php');
require_once('includes/functions.php');

session_start();

$sql = "SELECT * FROM pokemon";
$result = $conn->query($sql);

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

    <div class="pokemon_container">
        <?php while ($row = $result->fetch_assoc()): ?>
        <a
            href="pokemon.php?id=<?php echo $row['id']; ?>">
            <div class="card">
                <h3 class="pkmn_name">
                    <?php echo $row['name']; ?>
                </h3>
                <img
                    src=<?php echo $row['image']; ?>
                class="pkmn_sprite"
                alt="<?php echo $row['name']; ?>">
            </div>
        </a>
        <?php endwhile; ?>
    </div>



</body>

</html>