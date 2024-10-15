<?php
// Alexis Boisset

require "../model/db_conn.php"; // Inclou la classe Database per a la connexió

// Funció per obtenir totes les files d'articles
function solicitudRows()
{
    try {
        $database = new Database();
        $conn = $database->connect(); // Crea una connexió a la base de dades
    } catch (PDOException $e) {
        die("Error de connexió: " . $e->getMessage());
    }
    $articles = $database->allArticles($conn); // Recupera totes les files d'articles
    if (empty($articles)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    return $articles; // Retorna les files obtingudes
}