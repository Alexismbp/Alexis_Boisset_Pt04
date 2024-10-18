<?php
// Alexis Boisset
// Control de inactividad
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 30)) {
    // Si han pasado más de 40 minutos
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['DOCUMENT_ROOT'] . "vista/login.vista.php"); // Redirigir al login
    exit(); 
}
$_SESSION['LAST_ACTIVITY'] = time(); // Actualizar el tiempo de última actividad
