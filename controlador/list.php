<?php
// Alexis Boisset

require "../model/db_conn.php"; // Inclou la classe Database per a la connexió
require "../model/porra.php";

solicitudRows();
// Funció per obtenir totes les files d'partits$partits
function solicitudRows()
{
    $id = 1;
    try {
        $conn = connect();
    } catch (PDOException $e) {
        die("Error de connexió: " . $e->getMessage());
    }
    $partits = consultarPartido($conn, $id); // Recupera totes les files d'partits$partits
    if (empty($partits)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    return $partits->fetch(PDO::FETCH_ASSOC); // Retorna les files obtingudes
}
