<?php
// Alexis Boisset
try {
    session_start();

    require '../model/db_conn.php';
    require '../model/user_model.php';

    //DEBUGGING
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST['username'] = "Xavi";
    $_POST['password'] = "Admin123";
    $_POST['password_confirm'] = "Admin123";
    $_POST['email'] = "xavi@gmail.com";
    $_POST['equip'] = "Girona FC";  // Equipo favorito

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn = connect()) {

        $nomUsuari = validate($_POST['username']);
        $contrasenya = validate($_POST['password']);
        $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
        $passwordConfirm = validate($_POST['password_confirm']);
        $email = validate($_POST['email']);
        $equipFavorit = validate($_POST['equip']);
        $missatgesError = [];
        $error = false;

        // Validación de campos
        if (empty($nomUsuari)) {
            $missatgesError[] = "El nom d'usuari no pot estar buit";
            $error = true;
        }

        if (empty($contrasenya)) {
            $missatgesError[] = "És obligatori una contrasenya";
            $error = true;
        } elseif (preg_match($passwordPattern, $contrasenya) === 0) {
            $missatgesError[] = "La contrasenya ha de tenir mínim: 8 caràcters, una majúscula, una minúscula i un dígit";
            $error = true;
        }

        if (empty($email)) {
            $missatgesError[] = "És obligatori un correu electrònic";
            $error = true;
        }

        if (empty($equipFavorit)) {
            $missatgesError[] = "És obligatori un equip favorit";
            $error = true;
        }

        if ($contrasenya !== $passwordConfirm) {
            $missatgesError[] = "Les contrasenyes no coincideixen";
            $error = true;
        }

        if ($error) {
            throw new Exception();
        }

        // Encriptamos la contraseña
        $contrasenyaHashed = password_hash($contrasenya, PASSWORD_DEFAULT);

        // Registrar usuario
        if (registerUser($nomUsuari, $email, $contrasenyaHashed, $equipFavorit, $conn)) {

            // Asignar valores a la sesión
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $nomUsuari;
            $_SESSION['equip'] = $equipFavorit;
            $_SESSION['lliga'] = getLeagueName($equipFavorit, $conn);
            $_SESSION['success'] = "Usuari registrat correctament";

            // Redireccionar a la página de inicio
            header("Location: ../index.php");
            exit();
        } else {
            $missatgesError[] = "Aquest correu electrònic ja s'està utilitzant";
            throw new Exception();
        }
    }
} catch (Throwable $th) {
    $_SESSION['failure'] = "Hi ha hagut un error: " . $th->getMessage();
    $_SESSION['errors'] = $missatgesError;
    $_SESSION['username'] = $nomUsuari;
    $_SESSION['email'] = $email;
    $_SESSION['equip'] = $equipFavorit;
} finally {
    header("Location: ../vista/register.view.php");
    exit();
}

function validate($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}
