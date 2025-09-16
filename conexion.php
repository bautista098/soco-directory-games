<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root"; // o tu usuario real
$pass = "";     // o tu contraseña real
$db   = "Socogames";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

echo "✅ Conectado a la base de datos correctamente";
?>

