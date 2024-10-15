<?php
// Alexis Boisset

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí iría la lógica para registrar al usuario.
    $username = $_POST['username'];
    $password = $_POST['password'];

    // En un sistema real, guardarías esto en la base de datos.
    // Ejemplo sencillo de registro.
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
}
?>

