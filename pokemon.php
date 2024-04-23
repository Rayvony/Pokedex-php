<?php
require_once('includes/db.php');
require_once('includes/functions.php');

session_start();

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pokemonId = $_GET['id'];

    $sql = "SELECT * FROM pokemon WHERE id = $pokemonId";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $pokemon = $result->fetch_assoc();
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pokemon['name']; ?>
    </title>
    <link rel="stylesheet" href="css/detail.css">
</head>

<body>
    <div class="pokemon_detail">
        <div class="detail_image">
            <img
                src=<?php echo $pokemon['image']; ?>
            alt="<?php echo $pokemon['name']; ?>">
        </div>
        <div>
            <h1><?php echo $pokemon['name'] . ' #' . $pokemon['dexNumber'];?>
            </h1>
            <p>Pokédex entry:
                <?php echo $pokemon['description']; ?>
            </p>
            <p>Types:
                <?php
            $sqlTypes = "SELECT t.name FROM type t JOIN pokemon_type pt ON t.id = pt.type_id WHERE pt.pokemon_id = $pokemonId"; ?>
        </div>
        <?php

$resultTypes = $conn->query($sqlTypes);
echo '<div class="types">';
while ($rowType = $resultTypes->fetch_assoc()) {
    echo '<img class="icon ' . $rowType['name'] . '" src="/pokedex/assets/types/' . $rowType['name'] . '.svg" alt="' . $rowType['name'] . '">';
}
echo '</div>';
?>
    </div>

</body>

</html>