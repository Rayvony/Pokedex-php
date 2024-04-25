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
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/detail.css">
</head>

<body>

    <?php include('header.php'); ?>
    <div class="pokemon_detail">
        <h1 class="pokemonName">
            <?php echo $pokemon['name']; ?>
        </h1>
        <div class="detail_image">
            <img src="<?php echo $pokemon['image']; ?>"
                alt="<?php echo $pokemon['name']; ?>">
        </div>
        <p>#<?php echo $pokemon['dexNumber']; ?>
        </p>
        <p>Pokédex entry:</p>
        <p class="description">
            <?php echo $pokemon['description']; ?>
        </p>
        <p>Types:</p>
        <div class="types">
            <?php
            $sqlTypes = "SELECT t.name FROM type t JOIN pokemon_type pt ON t.id = pt.type_id WHERE pt.pokemon_id = $pokemonId";
$resultTypes = $conn->query($sqlTypes);
while ($rowType = $resultTypes->fetch_assoc()) {
    echo '<div class="icon ' . $rowType['name'] . '"><img src="/pokedex/assets/types/' . $rowType['name'] . '.svg" alt="' . $rowType['name'] . '"></div>';
}
?>
        </div>
    </div>

</body>
<?php include('footer.php'); ?>

</html>