<?php
session_start();
include("cnx.php");
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Connexion.php');
    exit();
}
$user_id = intval($_SESSION['user_id']);
$old = isset($_POST['old_password']) ? $_POST['old_password'] : '';
$new = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$confirm = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
if ($new === '' || $confirm === '' || $new !== $confirm) {
    header('Location: ../profil.php?error=mdp');
    exit();
}
// Vérifier l'ancien mot de passe
$stmt = $cnx->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($hash);
$stmt->fetch();
$stmt->close();
if (!password_verify($old, $hash)) {
    header('Location: ../profil.php?error=old');
    exit();
}
// Mettre à jour le mot de passe
$new_hash = password_hash($new, PASSWORD_DEFAULT);
$stmt2 = $cnx->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt2->bind_param("si", $new_hash, $user_id);
if ($stmt2->execute()) {
    header('Location: ../profil.php?success=2');
    exit();
} else {
    header('Location: ../profil.php?error=update');
    exit();
}