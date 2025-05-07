<?php
include("cnx.php");
session_start();

// Réinitialisation des variables de session
$_SESSION['id'] = '';
$_SESSION['nom'] = '';
$_SESSION['role'] = '';
$_SESSION['error'] = '';
$_SESSION['success'] = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($cnx, trim($_POST['username']));
    $password = $_POST['password'];
    
    // Requête préparée pour récupérer les infos utilisateur + rôle
    $stmt = mysqli_prepare($cnx, "SELECT id, nom, pass, role FROM user WHERE nom = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Vérification du mot de passe
        if (password_verify($password, $row['pass'])) {
            // Mise à jour des variables de session
            $_SESSION['id'] = $row['id'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['success'] = "Connexion réussie !";
            
            // Redirection selon le rôle
            
        }
    }
    
    // Si échec de connexion
    $_SESSION['error'] = "Identifiants incorrects ou compte inexistant";
    header("Location: ../main.php");
    exit();
}

mysqli_close($cnx);
?>