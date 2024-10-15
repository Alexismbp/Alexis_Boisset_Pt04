<?php

$servername = "127.0.0.1";  // Host del servidor MySQL
$dbname = "Pt04_Alexis_Boisset";  // Nom de la base de dades
$username = "root";  // Nom d'usuari MySQL
$password = "";  // Contrasenya MySQL


// DSN correctament formatat
function connect()
{
    try {
        global $servername, $dbname, $username, $password;

        // Convertir el nombre de la base de datos a minúsculas para evitar problemas
        $dbname = strtolower($dbname);

        // Generar el DSN con el nombre de la base de datos en minúsculas
        $dsn = "mysql:host=" . $servername . ";dbname=" . $dbname;


        // Creem una nova connexió PDO
        $conn = new PDO($dsn, $username, $password);

        // Configurem PDO perquè llanci excepcions en cas d'error
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (PDOException $e) {
        die("Error de connexió: " . $e->getMessage());
        return null;
    }
}
