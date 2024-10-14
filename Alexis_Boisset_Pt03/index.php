<!-- Alexis Boisset -->
<?php

/*
Testament:   
La plantilla que has passat em fa dubtar de si estic utilitzant el Model-Vista-Controlador correctament
perque si no le he entés malament ens estás demanant que fem operacions y consultes a la base de dades en el mateix fitxer (?)
O sigui fa de Model i Controlador a la vegada i després fa un require de la vista (?????). Bueno no sé si es correcte el que he fet.

La majoría de cosas que hi ha están reciclades de la Pt02.
*/

// Reinicia les variables de sessió
session_reset();

// Ens connectem a la base de dades	
require "./model/database.php";

$database = new Database();
$conn = $database->connect();

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

/* 
Xavi, aquest comentari que has posat a la plantilla no l'he entés per que, a on vols que redirigeixi? Ja estic a l'Index i millor que aquí en ningún lloc
Comentari que no vaig entendre: // Comprovem que hagui articles, en cas contrari, rediriguim
Igualment a l'arxiu de controlador `list.php` he fet un if (empty) {header...} pero no veig la utilitat 
*/

// Calculem el total d'articles per a poder conèixer el número de pàgines de la paginació
$totalArticles = $conn->query("SELECT COUNT(*) FROM articles")->fetchColumn();

// Calculem el numero de pagines que tindrà la paginació. Llavors hem de dividir el total d'articles entre els POSTS per pagina
/* Funcionament de ceil (ceiling) per si no l'has vist mai:
   value rounded up to the next highest integer. @return Float*/
$totalPages = ceil($totalArticles / $postsPerPage);

require "vista/index.vista.php";