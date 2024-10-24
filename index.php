<!-- Alexis Boisset -->
<?php
require "controlador/config.php";
require "./model/db_conn.php";

session_start();
//DEBUGGING
$_SESSION['equip'] = "OGC Nice";
$_SESSION['lliga'];

// Definir el número de partidos por página
if (isset($_GET['partitsPerPage'])) {
    $partitsPerPage = (int)$_GET['partitsPerPage'];
    setcookie('partitsPerPage', $partitsPerPage, time() + (86400 * 30), "/"); // Cookie válida por 30 días
} elseif (isset($_COOKIE['partitsPerPage'])) {
    $partitsPerPage = (int)$_COOKIE['partitsPerPage'];
} else {
    $partitsPerPage = 5; // Valor por defecto
}

// Selección de la lliga
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    // Si el usuario está logueado, usamos la lliga de su equipo favorito
    $lligaSeleccionada = $_SESSION['lliga'];
} else {
    // Si no está logueado, usamos la cookie o el valor por defecto
    if (isset($_GET['lliga'])) {
        $lligaSeleccionada = $_GET['lliga'];
        setcookie('lliga', $lligaSeleccionada, time() + (86400 * 30), "/"); // Cookie válida por 30 días
    } elseif (isset($_COOKIE['lliga'])) {
        $lligaSeleccionada = $_COOKIE['lliga'];
    } else {
        $lligaSeleccionada = 'laliga'; // Valor por defecto
    }
}

$conn = connect();

// Determinar la página actual
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $partitsPerPage;

// Consulta SQL según si el usuario está logado o no
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $equipFavorit = $_SESSION['equip'];
    $sql = "SELECT p.id, p.data, e_local.nom AS equip_local, e_visitant.nom AS equip_visitant, p.gols_local, p.gols_visitant, p.jugat, l.nom AS lliga
            FROM partits p
            JOIN equips e_local ON p.equip_local_id = e_local.id
            JOIN equips e_visitant ON p.equip_visitant_id = e_visitant.id
            JOIN lligues l ON p.liga_id = l.id
            WHERE (e_local.nom = :equip OR e_visitant.nom = :equip)
            AND l.nom = :lliga
            LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':equip', $equipFavorit, PDO::PARAM_STR);
    $stmt->bindValue(':lliga', $lligaSeleccionada, PDO::PARAM_STR);
} else {
    $sql = "SELECT p.id, p.data, e_local.nom AS equip_local, e_visitant.nom AS equip_visitant, p.gols_local, p.gols_visitant, p.jugat, l.nom AS lliga
            FROM partits p
            JOIN equips e_local ON p.equip_local_id = e_local.id
            JOIN equips e_visitant ON p.equip_visitant_id = e_visitant.id
            JOIN lligues l ON p.liga_id = l.id
            WHERE l.nom = :lliga
            LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':lliga', $lligaSeleccionada, PDO::PARAM_STR);
}

$stmt->bindValue(':limit', $partitsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$partits = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Calcular total de partidos para la paginación
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $totalPartitsStmt = $conn->prepare("SELECT COUNT(*) 
                                        FROM partits p
                                        JOIN equips e_local ON p.equip_local_id = e_local.id
                                        JOIN equips e_visitant ON p.equip_visitant_id = e_visitant.id
                                        JOIN lligues l ON p.liga_id = l.id
                                        WHERE (e_local.nom = :equip OR e_visitant.nom = :equip)
                                        AND l.nom = :lliga");
    $totalPartitsStmt->bindValue(':equip', $equipFavorit, PDO::PARAM_STR);
    $totalPartitsStmt->bindValue(':lliga', $lligaSeleccionada, PDO::PARAM_STR);
} else {
    $totalPartitsStmt = $conn->prepare("SELECT COUNT(*) 
                                        FROM partits p
                                        JOIN lligues l ON p.liga_id = l.id
                                        WHERE l.nom = :lliga");
    $totalPartitsStmt->bindValue(':lliga', $lligaSeleccionada, PDO::PARAM_STR);
}

$totalPartitsStmt->execute();
$totalPartits = $totalPartitsStmt->fetchColumn();

$totalPages = ceil($totalPartits / $partitsPerPage);

include "./vista/index.vista.php";
?>