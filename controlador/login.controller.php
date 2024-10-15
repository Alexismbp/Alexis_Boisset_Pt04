<?php
// Alexis Boisset

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí iría la lógica para autenticar al usuario.
    // Comprobar credenciales y redirigir si son correctas.
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Ejemplo sencillo para simular autenticación (en un proyecto real, verifica con la base de datos).
    if ($username === 'alexis' && $password === 'password123') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Credencials incorrectes.";
    }
}
?>