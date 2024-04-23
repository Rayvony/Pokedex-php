<?php

$config_path = $_SERVER['DOCUMENT_ROOT'] . '/pokedex/config.ini';
$config = parse_ini_file($config_path);

$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['database']);

if ($conn->connect_error) {
    die("Failed connection: " . $conn->connect_error);
}
