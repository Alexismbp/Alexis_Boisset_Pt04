<?php
// user_model.php
require_once 'db_conn.php';

function registerUser($username, $email, $password, $equipFavorit)
{
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
    $insertQuery = $conn->prepare("INSERT INTO usuaris (id, nom_usuari, correu_electronic, contrasenya, equip_favorit) VALUES (:id, :username, :email, :password, :team)");
    $insertQuery->bindParam(':id', ultimaIdDisponible());
    $insertQuery->bindParam(':username', $username);
    $insertQuery->bindParam(':email', $email);
    $insertQuery->bindParam(':password', $hashedPassword);
    $insertQuery->bindParam(':team', $equipFavorit);

    return $insertQuery->execute();
}

function getUserData($email)
{
    global $conn;
    $sql = $conn->prepare("SELECT correu_electronic FROM usuaris WHERE correu_electronic = :email");
    $sql->bindParam(':email', $email);
    $sql->execute();
    $dbEmail = $sql->fetch(PDO::FETCH_ASSOC);

    if ($dbEmail['correu_electronic'] === $email) {
        $sql = $conn->prepare("SELECT nom_usuari, contrasenya FROM usuaris WHERE correu_electronic = :email");
        $sql->bindParam(':email', $email);

        $sql->execute();
        $hashedPassword = $sql->fetch(PDO::FETCH_ASSOC);
        return $hashedPassword;
    } else {
        return false;
    }
}

/* Funció que serveix per a omplenar les diferències que hi ha entre les ID d'una fila a una altra. */
function ultimaIdDisponible()
{
    global $conn;
    
    $contador = 1;

    $query = "SELECT id FROM usuaris";
    $allId = $conn->prepare($query);

    $allId->execute();

    // Fetching IDs into an array
    $idDisponible = $allId->fetchAll(PDO::FETCH_COLUMN, 0);

    foreach ($idDisponible as $idActual) {
        if ($contador != $idActual) {
            return $contador; // Retorna l'ID disponible si no coincideix
        }
        $contador++;
    }

    return $contador; // Retorna el contador si no hi ha buits
}