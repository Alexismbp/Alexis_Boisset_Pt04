<!-- Alexis Boisset -->
<?php

// Ens connectem a la base de dades	
require "./model/db_conn.php";

$conn = connect();

// Definim quants post per pagina volem carregar. (In english perque sona millor)
$postsPerPage = 5;

/* Revisem des de quin article anem a carregar, depenent de la pagina on es trobi l'usuari. */

// Establim el numero de pagina en la que l'usuari es troba.
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

// Calcular l'offset per a la consulta SQL
$offset = ($page - 1) * $postsPerPage;

// Preparem la consulta SQL 

$sql = "SELECT titol, cos FROM articles LIMIT :limit OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':limit', $postsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

// Executem la consulta
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Calculem el total d'articles per a poder conèixer el número de pàgines de la paginació
$totalArticles = $conn->query("SELECT COUNT(*) FROM articles")->fetchColumn();

// Calculem el numero de pagines que tindrà la paginació. Llavors hem de dividir el total d'articles entre els POSTS per pagina
$totalPages = ceil($totalArticles / $postsPerPage);

require "vista/index.vista.php";