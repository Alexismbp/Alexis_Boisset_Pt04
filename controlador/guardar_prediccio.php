<?php
session_start();
require '../model/db_conn.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos
require '../model/porra.php';

if (!isset($_SESSION['usuari_id'])) {
    header('Location: login.php'); // Redirigir si no está autenticado
    exit;
}

if ($_SERVER['REQUEST_METHOD' === 'POST' && $conn = connect()]) {
    // Obtener los datos del formulario
    $partit_id = $_POST['partit_id'];
    $gols_local = $_POST['gols_local'];
    $gols_visitant = $_POST['gols_visitant'];
    $usuari_id = $_SESSION['usuari_id'];

    // Guardar la predicción y redirigir
    if (guardarPrediccio($pdo, $partit_id, $usuari_id, $gols_local, $gols_visitant)) {
        header('Location: index.vista.php'); // Redirigir después de guardar
    } else {
        echo "Error al guardar la predicción.";
    }
}
