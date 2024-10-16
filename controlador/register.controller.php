<?php
// Alexis Boisset
session_start();

require '../model/user_model.php';

FALTA AÑADIR EQUIPO PARA INSERTAR EN BASE DE DATOS
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $email = validate($_POST['email']);

    if (registerUser($username, $email, $password)) {

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

}

function validate ($data) {
    trim($data);
    htmlspecialchars($data);
    stripslashes($data);
    filter_var($data);
}

