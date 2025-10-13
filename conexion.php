<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root"; // o tu usuario real phmyadmin
$pass = "";     // o tu contraseña real contraseña RedesInformaticas
$db   = "Socogames";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

echo "";
?>

