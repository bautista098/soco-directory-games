<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $email   = $_POST["email"];
    $clave   = password_hash($_POST["clave"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (username, password, email) VALUES ('$usuario', '$clave', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "✅ Usuario registrado. <a href='login.php'>Iniciar sesión</a>";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>

<form method="post">
  Usuario: <input type="text" name="usuario"><br>
  Email: <input type="email" name="email"><br>
  Contraseña: <input type="password" name="clave"><br>
  <input type="submit" value="Registrar">
</form>

