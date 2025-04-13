<?php
include("cnx.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($cnx, trim($_POST['username']));
    $email = mysqli_real_escape_string($cnx, trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas";
        header('Location: ../index.php');
        exit();
    }
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $_SESSION['error'] = "Nom d'utilisateur invalide";
        header('Location: ../index.php');
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/i', $email)) {
        $_SESSION['error'] = "Email invalide (seuls les Gmail sont acceptés)";
        header('Location: ../index.php');
        exit();
    }
    $stmt = mysqli_prepare($cnx, "SELECT nom FROM user WHERE nom = ? OR mail = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Ce nom d'utilisateur ou email est déjà utilisé";
        header('Location: ../index.php');
        exit();
    }
    mysqli_stmt_close($stmt);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = mysqli_prepare($cnx, "INSERT INTO user (nom, mail, pass) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        header("Location: ../connexion.php");
        exit();
    } else {
        $_SESSION['error'] = "Erreur lors de l'inscription: " . mysqli_error($cnx);
        header('Location: ../index.php');
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($cnx);
}
?>