<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: /pokedex/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
    $search = validate_input($_GET["search"]);

    $sql = "SELECT * FROM pokemon WHERE name LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $errorMessage = "";
    } else {
        header("Location: dashboard.php?error=1");
        exit();
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex - Dashboard</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>

    <div class="header">
        <img src='../assets/Firma.svg' alt='logo' class="firma" />

        <form class="search" action="search.php" method="get">
            <input class="searchTerm" type="text" name="search" placeholder="Search Pokémon by name">
            <button type="submit">Search</button>
        </form>
        <form action="../logout.php" method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>

    <div class="pokemon_container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Dex Number</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Type</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?>
                    </td>
                    <td><?php echo $row['dexNumber']; ?>
                    </td>
                    <td>
                        <a class="pkmn_name"
                            href="/pokedex/pokemon.php?id=<?php echo $row['id']; ?>">
                            <?php echo $row['name']; ?>
                        </a>
                    </td>
                    <td>
                        <a class="pkmn_name"
                            href="/pokedex/pokemon.php?id=<?php echo $row['id']; ?>">
                            <img class="pkmn_img"
                                src="<?php echo $row['image']; ?>"
                                alt="<?php echo $row['name']; ?>">
                        </a>
                    </td>
                    <td>
                        <?php
                    $pokemonId = $row['id'];
                    $sqlTypes = "SELECT t.name FROM type t JOIN pokemon_type pt ON t.id = pt.type_id WHERE pt.pokemon_id = $pokemonId";
                    $resultTypes = $conn->query($sqlTypes);
                    echo '<div class="types">';
                    while ($rowType = $resultTypes->fetch_assoc()) {
                        echo '<div class="icon ' . $rowType['name'] . '"><img src="/pokedex/assets/types/' . $rowType['name'] . '.svg" alt="' . $rowType['name'] . '"></div>';
                    }
                    echo '</div>';
                    ?>
                    </td>
                    <td><a
                            href="editPokemon.php?id=<?php echo $row['id']; ?>"><button>Edit</button></a>
                    </td>
                    <td><a
                            href="deletePokemon.php?id=<?php echo $row['id']; ?>"><button>Delete</button></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <button><a href="addPokemon.php">Add Pokémon</a></button>
    </div>
</body>

</html>