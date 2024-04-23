<?php

$config = parse_ini_file('config.ini');

$conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['database']);

if ($conn->connect_error) {
    die("Failed connection: " . $conn->connect_error);
}
