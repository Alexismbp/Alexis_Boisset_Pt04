<?php
// Alexis Boisset

try {
    require "../model/database.php"; // Inclou la classe Database per a la connexió

    try {
        $database = new Database();
        $conn = $database->connect(); // Crea una connexió a la base de dades
    } catch (PDOException $e) {
        die("Error de connexió: " . $e->getMessage());
    }

    // Comprovar si la connexió és correcta i si la petició és POST
    if ($conn && $_SERVER["REQUEST_METHOD"] === "POST") {
        $id = $_POST["id"]; // Recupera l'ID del formulari

        // Validar que l'ID no estigui buit i sigui numèric
        if (!empty($id) && is_numeric($id)) {
            $resultat = $database->delete($conn, $id); // Prepara l'eliminació
        } else {
            header("Location: ../vista/eliminar.php?error=2"); // Error: ID no vàlid
            exit();
        }

        // Executar la consulta d'eliminació
        if ($resultat->execute()) {
            header("Location: ../vista/eliminar.php?success"); // Redirigeix amb èxit
            exit();
        }
    }
} catch (Exception $e) {
    echo "S'ha produit un error: " . $e->getMessage(); // Mostra error si ocorre una excepció
    header("Location: ../vista/eliminar.php?failure"); // Redirigeix en cas de fallida
    exit();
}
