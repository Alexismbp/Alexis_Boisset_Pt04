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

            $nomUsuari = $userData['nom_usuari'];
            $hashedPassword = $userData['contrasenya']; // La contraseña almacenada
            $equip = $userData['equip_favorit'];

            // Obtener la lliga del equipo favorito
            $sql = "SELECT l.nom AS lliga FROM equips e
                    JOIN lligues l ON e.lliga_id = l.id
                    WHERE e.nom = :equip";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':equip', $equip, PDO::PARAM_STR);
            $stmt->execute();
            $lliga = $stmt->fetchColumn();

            // Usar password_verify para verificar la contraseña ingresada
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['loggedin'] = true;
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
