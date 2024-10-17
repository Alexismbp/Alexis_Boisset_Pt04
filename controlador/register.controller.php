<?php
// Alexis Boisset
try {
    session_start();

    require '../model/user_model.php';

    // $_SERVER['REQUEST_METHOD'] === 'POST' && 

    if ($conn = connect()) {

        $username = validate($_POST['username']);
        $password = validate($_POST['password']);
        $passwordConfirm = validate($_POST['password_confirm']);
        $email = validate($_POST['email']);
        $equipFavorit = validate($_POST['equip']);
        $missatgesError = [];
        $error = false;

        if (empty($username)) {
            $missatgesError[] = "El nom d'usuari no pot estar buit";
            $error = true;
        }

        if (empty($password)) {
            $missatgesError[] = "Es obligatori una contrasenya";
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
            $_SESSION['errors'] = $missatgesError;
            header("Location: ../vista/register.view.php");
            exit();
        }


        if (registerUser($username, $email, $password, $equipFavorit)) {

            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Usuari registrat correctament";
        }
    }
} catch (Throwable $th) {
    $_SESSION['failure'] = "Hi ha hagut un error: " . $th->getMessage();
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
