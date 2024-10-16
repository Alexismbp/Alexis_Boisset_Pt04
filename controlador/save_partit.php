<?php
// Alexis Boisset
session_start();

require "../model/db_conn.php";
require "../model/porra.php";

try {
    $conn = connect();
} catch (PDOException $e) {
    die("Error de connexió: " . $e->getMessage());
}

if ($conn) {
    // Obtenim i netegem les dades del formulari
    $id = trim($_POST["id"] ?? null);
    $equip_local = trim($_POST["equip_local"]);
    $equip_visitant = trim($_POST["equip_visitant"]);
    $data = trim($_POST["data"]);
    $gols_local = trim($_POST["gols_local"] ?? null);
    $gols_visitant = trim($_POST["gols_visitant"] ?? null);
    $missatgesError = [];
    $error = false;

    // Comprobar camps buits
    if (empty($equip_local)) {
        $missatgesError[] = 'L\'equip local no pot estar buit';
        $error = true;
    }

    if (empty($equip_visitant)) {
        $missatgesError[] = 'L\'equip visitant no pot estar buit';
        $error = true;
    }

    if (empty($data)) {
        $missatgesError[] = 'La data no pot estar buida';
        $error = true;
    }

    // Verificació de l'ID
    if (!empty($id) && !is_numeric($id)) {
        $missatgesError[] = 'L\'ID ha de ser numèric';
        $error = true;
    } elseif (!empty($id)) {
        // Consulta el partit per editar
        $resultat = consultarPartido($conn, $id);
        $partit = $resultat->fetch(PDO::FETCH_ASSOC);

        if ($partit) {
            $_SESSION['equip_local'] = $partit['equip_local_id']; // Corregido: Asegurarse de que el campo que se obtiene es el correcto
            $_SESSION['equip_visitant'] = $partit['equip_visitant_id']; // Corregido: Asegurarse de que el campo que se obtiene es el correcto
            $_SESSION['data'] = $partit['data']; // Corregido: Asegurarse de que el campo que se obtiene es el correcto
            $_SESSION["id"] = $id;
            $_SESSION['editant'] = true;

            header("Location: ../vista/crear_partit.php");
            exit();
        } else {
            $missatgesError[] = "Aquest partit no existeix";
            $error = true;
        }
    }

    // Si hi ha errors, redirigeix amb errors
    if ($error) {
        $_SESSION["equip_local"] = $equip_local;
        $_SESSION["equip_visitant"] = $equip_visitant;
        $_SESSION["data"] = $data;
        $_SESSION["gols_local"] = $gols_local;
        $_SESSION["gols_visitant"] = $gols_visitant;
        $_SESSION['errors'] = $missatgesError;

        header("Location: ../vista/crear_partit.php");
        exit();
    }

    // Inserció o actualització del partit
    if (isset($_SESSION['id']) && is_numeric($_SESSION['id']) && $_SESSION['id'] > 0) {
        $resultat = updatePartido($conn, $_SESSION['id'], $equip_local, $equip_visitant, $data, $gols_local, $gols_visitant);
    } else {
        $resultat = insertPartido($conn, $equip_local, $equip_visitant, $data, $gols_local, $gols_visitant);
    }

    // Executa la consulta
    try {
        if ($resultat->execute()) {
            $_SESSION['success'] = "El partit s'ha inserit correctament!";
        } else {
            $_SESSION['failure'] = "Alguna cosa no ha funcionat com s'esperava";
        }
    } catch (\Throwable $th) {
        $_SESSION['failure'] = "Hi ha hagut un error: " . $th->getMessage();
    } finally {
        header("Location: ../vista/crear_partit.php");
        exit();
    }
} else {
    $_SESSION['failure'] = "Alguna cosa no ha funcionat com s'esperava";
    header("Location: ../vista/crear_partit.php");
    exit();
}
