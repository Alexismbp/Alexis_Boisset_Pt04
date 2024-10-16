<?php
// user_model.php
require_once 'db_conn.php';

function registerUser($username, $email, $password) {
    global $conn;
    
    // Validar si el usuario ya existe
    $query = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam(':email', $email);
    $query->bindParam(':username', $username);
    $query->execute();
    
    if ($query->rowCount() > 0) {
        return false; // El usuario ya existe
    }
    FALTA INSERTAR PARA QUE EL USUARIO TENGA EL EQUIPO FAVORITO
    
    // Encriptar contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insertar el nuevo usuario
    $insertQuery = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $insertQuery->bindParam(':username', $username);
    $insertQuery->bindParam(':email', $email);
    $insertQuery->bindParam(':password', $hashedPassword);
    
    return $insertQuery->execute();
}
