<?php
// Alexis Boisset
// Control de inactivitat (tret de StackOverflow)
// Obtener la URL base del servidor
define('BASE_URL', "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 2400) && ($_SESSION['loggedin'])) {
    // Si han pasado más de 40 minutos
    session_unset();
    session_destroy();


    header("Location: " . BASE_URL . "/vista/login.vista.php"); // Redirigir al login
    exit(); 
}
$_SESSION['LAST_ACTIVITY'] = time(); // Actualizar el tiempo de última actividad
