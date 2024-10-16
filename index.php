<!-- Alexis Boisset -->
 TO DO:
 AÑADIR EN CONTROLLERS I MODELS DE REGISTER EL EQUIPO FAVORITO
 CREAR LA TABLA PARA LOS PARTIDOS Y EQUIPOS
 ELIMINAR TABLA ARTICULOS I MODIFICAR PAGINACION DE INDEX PARA QUE MUESTRE PARTIDOS EN VEZ DE ARTICULOS
 COMPROBAR CREACION DE USUARIOS I TENER FEEDBACK DEL FORMULARIO DE CREACION DE USUSARIOS I VALIDACION DEL MISMO
 LUEGO DEL SIGN UP HACER EL LOGIN POR EMAIL I PASSWORD
 
<?php
session_start();

// Ens connectem a la base de dades	
require "./model/db_conn.php";

$conn = connect();

// Definim quants post per pagina volem carregar.
$postsPerPage = 5;

// Establim el numero de pagina en la que l'usuari es troba.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

// Calcular l'offset per a la consulta SQL
$offset = ($page - 1) * $postsPerPage;

// Preparem la consulta SQL 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    // Si l'usuari està logat, només mostra partits del seu equip favorit
    $equipFavorit = $_SESSION['equip'];
    $sql = "SELECT titol, cos FROM articles WHERE equip = :equip LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':equip', $equipFavorit, PDO::PARAM_STR);
    $stmt->bindValue(':limit', $postsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
} else {
    // Si no està logat, mostra tots els partits
    $sql = "SELECT titol, cos FROM articles LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':limit', $postsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
}

// Executem la consulta
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculem el total d'articles
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
    $totalArticles = $conn->prepare("SELECT COUNT(*) FROM articles WHERE equip = :equip");
    $totalArticles->bindValue(':equip', $equipFavorit, PDO::PARAM_STR);
    $totalArticles->execute();
    $totalArticles = $totalArticles->fetchColumn();
} else {
    $totalArticles = $conn->query("SELECT COUNT(*) FROM articles")->fetchColumn();
}

// Calculem el numero de pagines
$totalPages = ceil($totalArticles / $postsPerPage);

include "vista/index.vista.php";
?>
