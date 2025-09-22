<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida - Socogames</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="mensaje-exito">
    <h2>¡Bienvenido, <?php echo $_SESSION['usuario']; ?>! 🎮</h2>
    <p>Has iniciado sesión correctamente en Socogames.</p>
    <a href="principal.php">Ir a la pagina principal</a>
    
</div>
</body>
</html>

