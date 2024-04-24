<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: /pokedex/index.php");
    exit();
}

$error = '';


if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pokemonId = $_GET['id'];


    $sql = "SELECT * FROM pokemon WHERE id = $pokemonId";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $pokemon = $result->fetch_assoc();
    } else {

        header("Location: dashboard.php");
        exit();
    }
} else {

    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dexNumber = validate_input($_POST['dexnumber']);
    $name = validate_input($_POST['name']);
    $type1 = validate_input($_POST['type1']);
    $type2 = validate_input($_POST['type2']);
    $description = validate_input($_POST['description']);


    $image = $pokemon['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = upload_image($_FILES['image']);
        if (!$image) {
            $error = "Error al subir la imagen.";
        }
    }


    if (empty($error)) {

        $sql = "UPDATE pokemon SET dexNumber = '$dexNumber', name = '$name', description = '$description', image = '$image' WHERE id = $pokemonId";
        if ($conn->query($sql) === true) {

            $sqlDeleteTypes = "DELETE FROM pokemon_type WHERE pokemon_id = $pokemonId";

            $sqlUpdateType1 = "INSERT INTO pokemon_type (pokemon_id, type_id) VALUES ('$pokemonId', '$type1')";



            $conn->query($sqlDeleteTypes);

            $conn->query($sqlUpdateType1);

            if (!empty($type2)) {
                $sqlUpdateType2 = "INSERT INTO pokemon_type (pokemon_id, type_id) VALUES ('$pokemonId', '$type2')";
                $conn->query($sqlUpdateType2);
            }

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Error al editar el Pokémon en la base de datos: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pokémon</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <h1>Edit Pokémon</h1>

    <form
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $pokemonId; ?>"
        method="post" enctype="multipart/form-data">
        <label for="dexnumber">Dex Number:</label>
        <input type="text" id="dexnumber" name="dexnumber"
            value="<?php echo $pokemon['dexNumber']; ?>"
            required><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name"
            value="<?php echo $pokemon['name']; ?>"
            required><br>

        <label for="type1">First Type:</label>
        <select id="type1" name="type1" required>
            <option value="1">Normal</option>
            <option value="2">Fighting</option>
            <option value="3">Flying</option>
            <option value="4">Poison</option>
            <option value="5">Ground</option>
            <option value="6">Rock</option>
            <option value="7">Bug</option>
            <option value="8">Ghost</option>
            <option value="9">Steel</option>
            <option value="10">Fire</option>
            <option value="11">Water</option>
            <option value="12">Grass</option>
            <option value="13">Electric</option>
            <option value="14">Psychic</option>
            <option value="15">Ice</option>
            <option value="16">Dragon</option>
            <option value="17">Dark</option>
            <option value="18">Fairy</option>
        </select><br>

        <label for="type2">Second Type:</label>
        <select id="type2" name="type2">
            <option value="">None</option>
            <option value="1">Normal</option>
            <option value="2">Fighting</option>
            <option value="3">Flying</option>
            <option value="4">Poison</option>
            <option value="5">Ground</option>
            <option value="6">Rock</option>
            <option value="7">Bug</option>
            <option value="8">Ghost</option>
            <option value="9">Steel</option>
            <option value="10">Fire</option>
            <option value="11">Water</option>
            <option value="12">Grass</option>
            <option value="13">Electric</option>
            <option value="14">Psychic</option>
            <option value="15">Ice</option>
            <option value="16">Dragon</option>
            <option value="17">Dark</option>
            <option value="18">Fairy</option>
        </select><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"
            required><?php echo $pokemon['description']; ?></textarea><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*"><br>

        <button type="submit">Edit Pokémon</button>
    </form>

    <?php if (!empty($error)) : ?>
    <p><?php echo $error; ?></p>
    <?php endif; ?>

</body>

</html>