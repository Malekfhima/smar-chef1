<?php
include("cnx.php");
session_start();
$_SESSION['id'] = '';
$_SESSION['nom'] = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($cnx, trim($_POST['username']));
    $password = $_POST['password'];
    $stmt = mysqli_prepare($cnx, "SELECT id, nom, pass FROM user WHERE nom = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['pass'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['success'] = "Connexion réussie !";
            header("Location: ../main.php");
            exit();
        }
    }
    $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect";
    header("Location: ../connexion.php");
    exit();
}
mysqli_close($cnx);
?>