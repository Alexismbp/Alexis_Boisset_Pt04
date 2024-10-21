<?php
session_start();
require "controlador/config.php";
require "./model/db_conn.php";

$conn = connect();

/* $_POST['partitsPerPage'] = 10; */

// Definir el número de partidos por página.
if (isset($_GET['partitsPerPage'])) {
    $partitsPerPage = (int)$_GET['partitsPerPage'];
    setcookie('partitsPerPage', $partitsPerPage, time() + (86400 * 30), "/"); // Cookie válida por 30 días.
} elseif (isset($_COOKIE['partitsPerPage'])) {
    $partitsPerPage = (int)$_COOKIE['partitsPerPage'];
} else {
    $partitsPerPage = 5; // Valor por defecto.
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $partitsPerPage;

// Consulta SQL para obtener los partidos (según si el usuario está logado o no).
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $equipFavorit = $_SESSION['equip'];
    $sql = "SELECT p.id, p.data, e_local.nom AS equip_local, e_visitant.nom AS equip_visitant, p.gols_local, p.gols_visitant, jugat
            FROM partits p
            JOIN equips e_local ON p.equip_local_id = e_local.id
            JOIN equips e_visitant ON p.equip_visitant_id = e_visitant.id
            WHERE e_local.nom = :equip OR e_visitant.nom = :equip
            LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':equip', $equipFavorit, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $partitsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
} else {
    $sql = "SELECT p.id, p.data, e_local.nom AS equip_local, e_visitant.nom AS equip_visitant, p.gols_local, p.gols_visitant, jugat
            FROM partits p
            JOIN equips e_local ON p.equip_local_id = e_local.id
            JOIN equips e_visitant ON p.equip_visitant_id = e_visitant.id
            LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':limit', $partitsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
}

$stmt->execute();
$partits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular total de partidos para la paginación.
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $totalPartits = $conn->prepare("SELECT COUNT(*) FROM partits p
                                     JOIN equips e_local ON p.equip_local_id = e_local.id
                                     JOIN equips e_visitant ON p.equip_visitant_id = e_visitant.id
                                     WHERE e_local.nom = :equip OR e_visitant.nom = :equip");
    $totalPartits->bindValue(':equip', $equipFavorit, PDO::PARAM_STR);
    $totalPartits->execute();
    $totalPartits = $totalPartits->fetchColumn();
} else {
    $totalPartits = $conn->query("SELECT COUNT(*) FROM partits")->fetchColumn();
}

$totalPages = ceil($totalPartits / $partitsPerPage);

include "./vista/index.vista.php";
?>
