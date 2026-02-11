<?php
$servername = "blyjnae4cjdp59mspa6i-mysql.services.clever-cloud.com";
$username = "utxxwd0cf6thuyy8";
$password = "948zLtBTS817h1iROfoF";
$dbname = "blyjnae4cjdp59mspa6i";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
