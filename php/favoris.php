<?php
session_start();
include("cnx.php");

if (!isset($_SESSION['user_id'])) {
    die("Erreur : utilisateur non connecté.");
}
if (!isset($_POST['recette_id'], $_POST['action'])) {
    die("Erreur : données manquantes.");
}
$user_id = intval($_SESSION['user_id']);
$recette_id = intval($_POST['recette_id']);
$action = $_POST['action'];

if ($action === 'add') {
    $stmt = $cnx->prepare("INSERT IGNORE INTO user_favoris (user_id, recette_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $recette_id);
    $stmt->execute();
    $stmt->close();
} elseif ($action === 'remove') {
    $stmt = $cnx->prepare("DELETE FROM user_favoris WHERE user_id = ? AND recette_id = ?");
    $stmt->bind_param("ii", $user_id, $recette_id);
    $stmt->execute();
    $stmt->close();
} else {
    die("Erreur : action inconnue.");
}
header("Location: ../advanced.php?id=" . $recette_id);
exit();