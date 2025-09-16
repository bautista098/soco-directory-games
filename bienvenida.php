<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: principal.php");
    exit;
}
?>
<h2>Bienvenido <?php echo $_SESSION["usuario"]; ?> 🎮</h2>
<a href="logout.php">Cerrar sesión</a>
<a href="principal.php">ir a pagina principal</a>

