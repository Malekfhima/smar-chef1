<?php
include("cnx.php");
session_start();

// Réinitialisation des messages de session
$_SESSION['error'] = '';
$_SESSION['success'] = '';
$_SESSION['form_data'] = []; // Pour conserver les données du formulaire en cas d'erreur

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage des données
    $username = mysqli_real_escape_string($cnx, trim($_POST['username']));
    $email = mysqli_real_escape_string($cnx, trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Conservation des données du formulaire
    $_SESSION['form_data'] = [
        'username' => $username,
        'email' => $email
    ];

    // Validation des mots de passe
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas";
        header('Location: ../index.php');
        exit();
    }

    // Validation de la force du mot de passe
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre";
        header('Location: ../index.php');
        exit();
    }

    // Validation du nom d'utilisateur
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $_SESSION['error'] = "Nom d'utilisateur invalide (3-20 caractères alphanumériques)";
        header('Location: ../index.php');
        exit();
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@(gmail\.com|yahoo\.com|hotmail\.com)$/i', $email)) {
        $_SESSION['error'] = "Email invalide (seuls les emails Gmail, Yahoo et Hotmail sont acceptés)";
        header('Location: ../index.php');
        exit();
    }

    // Vérification de l'unicité
    $stmt = mysqli_prepare($cnx, "SELECT id FROM user WHERE nom = ? OR mail = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Ce nom d'utilisateur ou email est déjà utilisé";
        header('Location: ../index.php');
        exit();
    }
    mysqli_stmt_close($stmt);

    // Hachage sécurisé du mot de passe
    $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

    // Insertion avec rôle par défaut
    $role = 'user'; // Rôle par défaut
    $stmt = mysqli_prepare($cnx, "INSERT INTO user (nom, mail, pass, role) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashed_password, $role);

    if (mysqli_stmt_execute($stmt)) {
        // Nettoyage des données de formulaire stockées
        unset($_SESSION['form_data']);
        
        $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        header("Location: ../connexion.php");
        exit();
    } else {
        $_SESSION['error'] = "Une erreur technique est survenue. Veuillez réessayer.";
        error_log("Erreur inscription: " . mysqli_error($cnx)); // Log technique
        header('Location: ../index.php');
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($cnx);
}
?>