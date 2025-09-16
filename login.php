<?php
include "conexion.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $clave   = $_POST["clave"];

    $sql = "SELECT * FROM usuarios WHERE username='$usuario' OR email='$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($clave, $user["password"])) {
            $_SESSION["usuario"] = $user["username"];
            header("Location: bienvenida.php");
            exit;
        } else {
            echo "❌ Contraseña incorrecta";
        }
    } else {
        echo "❌ Usuario no encontrado";
    }
}
?>

<form method="post">
  Usuario o Email: <input type="text" name="usuario"><br>
  Contraseña: <input type="password" name="clave"><br>
  <input type="submit" value="Ingresar">
</form>

