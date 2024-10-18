<!-- Alexis Boisset -->

<?php
session_start(); // Inicia la sessió per a gestionar l'autenticació i les dades de l'usuari.

    /* $_SESSION['loggedin'] = true;
    $_SESSION['equip'] = "Valencia CF";
 */
require "./model/db_conn.php"; // Inclou el fitxer de connexió a la base de dades.

$conn = connect(); // Estableix la connexió a la base de dades.


$partitsPerPage = 5; // Nombre de partits a mostrar per cada pàgina.


$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Recupera la pàgina actual de la URL o estableix la pàgina 1 per defecte.


$offset = ($page - 1) * $partitsPerPage; // Calcula l'offset per a la consulta en funció de la pàgina actual.

// Preparem la consulta SQL 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    // Si l'usuari està logat, només mostra partits del seu equip favorit
    $equipFavorit = $_SESSION['equip']; 
    $sql = "SELECT p.data, e_local.nom AS equip_local, e_visitant.nom AS equip_visitant, p.gols_local, p.gols_visitant, jugat
            FROM partits p
            JOIN equips e_local ON p.equip_local_id = e_local.id
            JOIN equips e_visitant ON p.equip_visitant_id = e_visitant.id
            WHERE e_local.nom = :equip OR e_visitant.nom = :equip
            LIMIT :limit OFFSET :offset"; // Consulta per obtenir els partits del seu equip favorit.
    $stmt = $conn->prepare($sql); 
    $stmt->bindValue(':equip', $equipFavorit, PDO::PARAM_STR); // Vincula l'equip favorit a la consulta.
    $stmt->bindValue(':limit', $partitsPerPage, PDO::PARAM_INT); // Vincula el límit de resultats.
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Vincula l'offset.
} else {
    // Si no està logat, mostra tots els partits
    $sql = "SELECT p.data, e_local.nom AS equip_local, e_visitant.nom AS equip_visitant, p.gols_local, p.gols_visitant, jugat
            FROM partits p
            JOIN equips e_local ON p.equip_local_id = e_local.id
            JOIN equips e_visitant ON p.equip_visitant_id = e_visitant.id
            LIMIT :limit OFFSET :offset"; // Consulta per obtenir tots els partits.
    $stmt = $conn->prepare($sql); // Prepara la consulta.
    $stmt->bindValue(':limit', $partitsPerPage, PDO::PARAM_INT); // Vincula el límit de resultats.
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Vincula l'offset.

}

// Executem la consulta
$stmt->execute(); 
$partits = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recupera tots els resultats com un array associatiu.

// Calculem el total de partits
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $totalPartits = $conn->prepare("SELECT COUNT(*) FROM partits p
                                     JOIN equips e_local ON p.equip_local_id = e_local.id
                                     JOIN equips e_visitant ON p.equip_visitant_id = e_visitant.id
                                     WHERE e_local.nom = :equip OR e_visitant.nom = :equip"); // Consulta per comptar el total de partits del seu equip favorit.
    $totalPartits->bindValue(':equip', $equipFavorit, PDO::PARAM_STR); // Vincula l'equip favorit.
    $totalPartits->execute(); 
    $totalPartits = $totalPartits->fetchColumn(); // Recupera el total de partits.
} else {
    $totalPartits = $conn->query("SELECT COUNT(*) FROM partits")->fetchColumn(); // Consulta per comptar tots els partits si no està logat.
}


$totalPages = ceil($totalPartits / $partitsPerPage); // Calcula el nombre total de pàgines.

include "./vista/index.vista.php";
?>
