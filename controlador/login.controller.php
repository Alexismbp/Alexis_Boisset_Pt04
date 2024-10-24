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

        // Obtener los datos del usuario
        if ($userData = getUserData($email, $conn)) {

            $idUsuari = $userData['id'];
            $nomUsuari = $userData['nom_usuari'];
            $hashedPassword = $userData['contrasenya']; // La contraseña almacenada
            $equip = $userData['equip_favorit'];

            // Usar password_verify para verificar la contraseña ingresada
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['userid'] = $idUsuari;
                $_SESSION['username'] = $nomUsuari;
                $_SESSION['equip'] = $equip;
                $_SESSION['lliga'] = getLeagueName($equip, $conn);

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
    header("Location: ../vista/login.vista.php");
    exit();
}
