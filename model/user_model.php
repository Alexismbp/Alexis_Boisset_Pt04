<?php
// user_model.php
require_once 'db_conn.php';

function registerUser($username, $email, $password, $equipFavorit) {
    global $conn;
    
    // Validar si el usuario ya existe
    $query = $conn->prepare("SELECT * FROM usuaris WHERE correu_electronic = :email");
    $query->bindParam(':email', $email);
    //$query->bindParam(':username', $username);
    $query->execute();
    
    if ($query->rowCount() > 0) {
        return false; // El usuario ya existe
    }

    // Encriptar contraseña
    $hashedPassword = hash('sha256', $password);
    
    // Insertar el nuevo usuario
    $insertQuery = $conn->prepare("INSERT INTO usuaris (nom_usuari, correu_electronic, contrasenya, equip_favorit) VALUES (:username, :email, :password, :team)");
    $insertQuery->bindParam(':username', $username);
    $insertQuery->bindParam(':email', $email);
    $insertQuery->bindParam(':password', $hashedPassword);
    $insertQuery->bindParam(':team', $equipFavorit);
    
    return $insertQuery->execute();
}
