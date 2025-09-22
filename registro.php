<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario']);
    $email   = trim($_POST['email']);
    $pass    = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $usuario, $email, $pass);

    if ($stmt->execute()) {
        header("Location: login.php?msg=registrado");
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Socogames</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="form-container">
    <h2>Registro</h2>
    <?php if (isset($error)) echo "<p class='mensaje-error'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required><br>
        <input type="email" name="email" placeholder="Correo electrónico" required><br>
        <input type="password" name="password" placeholder="Contraseña" required><br>
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</div>
</body>
</html>

