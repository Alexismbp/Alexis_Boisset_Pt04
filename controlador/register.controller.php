<?php
// Alexis Boisset
try {
    session_start();

    require '../model/user_model.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $conn = connect()) {

        $username = validate($_POST['username']);
        $password = validate($_POST['password']);
        $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
        $passwordConfirm = validate($_POST['password_confirm']);
        $email = validate($_POST['email']);
        $equipFavorit = validate($_POST['equip']);
        $missatgesError = [];
        $error = false;

        /* $username = "";
        $password = "admin";
        $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
        $passwordConfirm = "admin";
        $email = "m.lopez@sapalomera.cat";
        $equipFavorit = "Sevilla FC";
        $missatgesError = [];
        $error = false; */

        if (empty($username)) {
            $missatgesError[] = "El nom d'usuari no pot estar buit";
            $error = true;
        }

        if (empty($password)) {
            $missatgesError[] = "Es obligatori una contrasenya";
            $error = true;
        } elseif (preg_match($passwordPattern, $password) === 0) {
            $missatgesError[] = "La contrasenya ha de tenir mínim: 8 caràcters, una majuscula, una minuscula y un digit";
            $error = true;
        }

        if (empty($email)) {
            $missatgesError[] = "Es obligatori un correu electrònic";
            $error = true;
        }

        if (empty($equipFavorit)) {
            $missatgesError[] = "Es obligatori una contrasenya";
            $error = true;
        }


        if (!$password === $passwordConfirm) {
            $missatgesError[] = "Les contrasenyes no coincideixen";
            $error = true;
        }

        if ($error) {
            throw new Exception();
            
        }


        if (registerUser($username, $email, $password, $equipFavorit)) {

            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Usuari registrat correctament";
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
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['equip'] = $equipFavorit;
} finally {
    header("Location: ../vista/register.view.php");
    exit();
}

function validate($data)
{
    trim($data);
    htmlspecialchars($data);
    stripslashes($data);
    filter_var($data);

    return $data;
}
