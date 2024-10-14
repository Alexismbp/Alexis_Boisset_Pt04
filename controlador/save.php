<?php
// Alexis Boisset

session_start(); // Inici de sessió per a gestionar dades d'usuari

require "../model/database.php"; // Inclou la classe Database

try {
    $database = new Database();
    $conn = $database->connect(); // Crea una connexió a la base de dades
} catch (PDOException $e) {
    die("Error de connexió: " . $e->getMessage());
}

if ($conn) {
    // Obtenim i netegem les dades del formulari
    $id = trim($_POST["id"] ?? null); // ID de l'article
    $nombre = trim($_POST["nombre"]); // Nom de l'article
    $descripcion = trim($_POST["descripcion"]); // Descripció de l'article
    $errorDesc = $errorNom = $errorId = ""; // Variables d'error
    $error = false; // Indicador d'error
    $calculError = 0; // Codi d'error

    // Comprovar si els camps estan buits
    if (empty($nombre)) {
        $calculError += 1; // Codi d'error per nom buit
        $error = true;
    }

    if (empty($descripcion)) {
        $calculError += 3; // Codi d'error per descripció buida
        $error = true;
    }

    // Verificació de l'ID
    if (!empty($id) && !is_numeric($id)) {
        $calculError += 5; // Codi d'error per ID no numèric
        $error = true;
    } elseif (!empty($id) && is_numeric($id) && empty($descripcion) && empty($nombre)) {
        $resultat = $database->consultarArticle($conn, $id); // Consulta l'article

        $article = $resultat->fetch(PDO::FETCH_ASSOC); // Resultat en format associatiu

        if ($article) {
            // Guardar les dades a la sessió
            $_SESSION['nombre'] = $article['titol']; // Títol
            $_SESSION['descripcion'] = $article['cos']; // Cos
            $_SESSION["id"] = $id; // ID

            header("Location: ../vista/crear.php?editant=true&id=" . $id); // Redirigeix a creació d'articles
            exit();
        } else {
            echo "Article no trobat."; // Missatge d'article no trobat
        }
    }

    // Si hi ha errors, es redirigeix amb codi d'errors
    if ($error) {
        $_SESSION["nombre"] = $_POST["nombre"]; // Nom
        $_SESSION["descripcion"] = $_POST["descripcion"]; // Descripció

        header("Location: ../vista/crear.php?errors=" . $calculError); // Redirigeix amb errors
        exit();
    }

    // Sanitització per a la base de dades
    $nombre = validarInput($nombre); // Sanititza el nom
    $descripcion = validarInput($descripcion); // Sanititza la descripció

    // Inserció o actualització de l'article
    if (isset($_SESSION['id']) && is_numeric($_SESSION['id']) && $_SESSION['id'] > 0) {
        $resultat = $database->update($conn, $_SESSION['id'], $nombre, $descripcion); // Actualitza
    } else {
        $resultat = $database->insert($conn, $nombre, $descripcion); // Insereix
    }

    // Executa la consulta
    try {
        if ($resultat->execute()) {
            header("Location: ../vista/crear.php?success"); // Redirigeix amb èxit
            $_SESSION = array(); // Neteja la sessió
        } else {
            print_r($resultat->errorInfo()); // Mostra errors
            header("Location: ../vista/crear.php?failure"); // Redirigeix amb fallida
        }
    } catch (\Throwable $th) {
        echo "Hi ha hagut un error: " . $th->getMessage(); // Mostra error si ocorre excepció
        exit();
    }
} else {
    header("Location: ../vista/crear.php?failure"); // Redirigeix si falla la connexió
    exit();
}

// Funció per validar i sanititzar l'input
function validarInput($data)
{
    $data = trim($data); // Elimina espais en blanc
    $data = filter_var($data); // Sanitització
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); // Evita injeccions
    return $data; // Retorna les dades sanititzades
}
