<?php

require_once '../includes/db.php';
require_once '../includes/functions.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: /pokedex/index.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pokemonId = $_GET['id'];

    $sqlDeleteTypes = "DELETE FROM pokemon_type WHERE pokemon_id = $pokemonId";
    if ($conn->query($sqlDeleteTypes) === true) {

        $sqlImageRoute = "SELECT image FROM pokemon WHERE id = $pokemonId";
        $result = $conn->query($sqlImageRoute);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $imageRoute = $_SERVER['DOCUMENT_ROOT'] . $row['image'];

            unlink($imageRoute);

        }

        $sqlDeletePokemon = "DELETE FROM pokemon WHERE id = $pokemonId";
        if ($conn->query($sqlDeletePokemon) === true) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Could not delete Pokémon: " . $conn->error;
        }
    } else {
        echo "Could not delete Pokémon types: " . $conn->error;
    }
} else {
    header("Location: dashboard.php");
    exit();
}
