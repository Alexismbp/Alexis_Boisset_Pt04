<?php
// Alexis Boisset
try {
    session_start();

    require "../model/db_conn.php";
    require "../model/user_model.php";

    $conn = connect();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($userData = getUserData($email, $conn)) {

            $nomUsuari = $userData['nom_usuari'];
            $hashedPassword = $userData['contrasenya'];
            $equip = $userData['equip_favorit'];

            

            if (hash_equals(hash('sha256', $password), $hashedPassword)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $nomUsuari;
                $_SESSION['equip'] = $equip;
                
                header("Location: ../index.php");
                exit();
            } else {
                $_SESSION['failure'] = "La contrasenya no es correcta";
            }
        } else {
            $_SESSION['failure'] = "L'usuari no existeix a la base de dades";
        }
    }
} catch (\Throwable $th) {
    $_SESSION['failure'] = "Error: " . $th->getMessage();
} finally {
    $_SESSION['username'] = $nomUsuari;
    header("Location: ../vista/login.vista.php");
    exit();
}
