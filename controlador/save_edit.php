<?php
// Alexis Boisset

require "../model/db_conn.php"; // Requerim la connexió a la Database
require "../model/porra.php"; // Requerim el CRUD

try {
    $conn = connect(); // Crea una connexió a la base de dades
} catch (PDOException $e) {
    die("Error de connexió: " . $e->getMessage());
}

if ($conn) {
    // Obtenim i netegem les dades del formulari
    $id = 1;//trim($_POST["id"] ?? null); // ID de l'article
    $nombre = trim($_POST["nombre"]); // Nom de l'article
    $descripcion = trim($_POST["descripcion"]); // Descripció de l'article
    $errorMessages = [];
    $error = false; // Indicador d'error
    

    // Comprovar si els camps estan buits
    if (empty($nombre)) {
        $errorMessages[] = 'El títol no pot estar buit'; // Error per nom buit
        $error = true;
    }

    if (empty($descripcion)) {
        $errorMessages[] = 'La descripció no pot estar buida'; // Error per descripció buida
        $error = true;
    }

    // Verificació de l'ID
    if (!empty($id) && !is_numeric($id)) {
        $errorMessages[] = 'L\'ID ha de ser numèric'; // Error per ID no numèric
        $error = true;
    } elseif (!empty($id) && is_numeric($id) && empty($descripcion) && empty($nombre)) {
        $resultat = consultarArticle($conn, $id); // Consulta l'article

        $article = $resultat->fetch(PDO::FETCH_ASSOC); // Resultat en format associatiu

        if ($article) {
            // Guardar les dades a la sessió
            $_SESSION['nombre'] = $article['titol']; // Títol
            $_SESSION['descripcion'] = $article['cos']; // Cos
            $_SESSION["id"] = $id; // ID
            $_SESSION['editant'] = true;

            header("Location: ../vista/crear.php"); // Redirigeix a creació d'articles
            exit();
        } else {
            echo "Article no trobat."; // Missatge d'article no trobat
        }
    }

    // Si hi ha errors, es redirigeix amb Errors
    if ($error) {
        $_SESSION["nombre"] = $_POST["nombre"]; // Nom
        $_SESSION["descripcion"] = $_POST["descripcion"]; // Descripció
        $_SESSION['errors'] = $errorMessages;

        header("Location: ../vista/crear.php"); // Redirigeix amb errors
        exit();
    }

    // Sanitització per a la base de dades
    $nombre = validarInput($nombre); // Sanititza el nom
    $descripcion = validarInput($descripcion); // Sanititza la descripció

    // Inserció o actualització de l'article
    if (isset($_SESSION['id']) && is_numeric($_SESSION['id']) && $_SESSION['id'] > 0) {
        $resultat = update($conn, $_SESSION['id'], $nombre, $descripcion); // Actualitza
    } else {
        $resultat = insert($conn, $nombre, $descripcion); // Insereix
    }

    // Executa la consulta
    try {
        if ($resultat->execute()) {
            $_SESSION['success'] = true;
            
        } else {
            print_r($resultat->errorInfo()); // Mostra errors
            $_SESSION['failure'] = true;
        }
    } catch (\Throwable $th) {
        echo "Hi ha hagut un error: " . $th->getMessage(); // Mostra error si ocorre excepció
    } finally {
        header("Location: ../vista/crear.php");
        exit();
    }
} else {
    $_SESSION['failure'] = true;
    header("Location: ../vista/crear.php"); // Redirigeix si falla la connexió
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
