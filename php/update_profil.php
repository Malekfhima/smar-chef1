<?php
session_start();
include("cnx.php");
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Connexion.php');
    exit();
}
$user_id = intval($_SESSION['user_id']);
$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
if ($nom === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../profil.php?error=invalid');
    exit();
}
$stmt = $cnx->prepare("UPDATE users SET nom = ?, email = ? WHERE id = ?");
$stmt->bind_param("ssi", $nom, $email, $user_id);
if ($stmt->execute()) {
    header('Location: ../profil.php?success=1');
    exit();
} else {
    header('Location: ../profil.php?error=update');
    exit();
}