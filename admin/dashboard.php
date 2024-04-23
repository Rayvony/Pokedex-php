<?php

require_once '../includes/db.php';
require_once '../includes/functions.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: /pokedex/index.php");
    exit();
}

$sql = "SELECT * FROM pokemon";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex - Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <h1>Pokédex - Dashboard</h1>
    <form action="../logout.php" method="post">
        <button type="submit" name="logout">Logout</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Dex Number</th>
                <th>Name</th>
                <th>Image</th>
                <th>Type</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?>
                </td>
                <td><?php echo $row['dexNumber']; ?>
                </td>
                <td><?php echo $row['name']; ?>
                </td>
                <td><img
                        src=<?php echo $row['image']; ?>
                    alt="<?php echo $row['name']; ?>">
                </td>
                <td>
                    <?php
                    $pokemonId = $row['id'];
                $sqlTypes = "SELECT t.name FROM type t JOIN pokemon_type pt ON t.id = pt.type_id WHERE pt.pokemon_id = $pokemonId";
                $resultTypes = $conn->query($sqlTypes);
                while ($rowType = $resultTypes->fetch_assoc()) {
                    echo $rowType['name'] . ' ';
                }
                ?>
                </td>
                <td><button>Edit</button></td>
                <td><button>Delete</button></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>



</body>

</html>