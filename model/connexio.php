<?php
try {

    $username = "root";
    $password = "";
    $host = "localhost";
    $dbname = "pt04_alexis_boisset";

    $conn = new PDO("mysql:host=" . $host . ";" . $dbname . "," . $username . "," . $password);
} catch (Exception $e) {
    echo "Error: ", $e->getMessage();
    die();
}
