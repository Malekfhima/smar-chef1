<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("cnx.php");

if (!isset($_POST['recette_id'], $_POST['note'], $_POST['commentaire'])) {
    die("Erreur : données manquantes.");
}
$recette_id = intval($_POST['recette_id']);
$user = isset($_POST['user']) && trim($_POST['user']) !== '' ? trim($_POST['user']) : null;
$note = intval($_POST['note']);
$commentaire = trim($_POST['commentaire']);

if ($note < 1 || $note > 5) {
    die("Erreur : note invalide.");
}
if ($commentaire === '') {
    die("Erreur : commentaire vide.");
}

$stmt = $cnx->prepare("INSERT INTO recette_avis (recette_id, user, note, commentaire) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isis", $recette_id, $user, $note, $commentaire);
if ($stmt->execute()) {
    header("Location: ../advanced.php?id=" . $recette_id . "#avis");
    exit();
} else {
    die("Erreur lors de l'enregistrement de l'avis : " . $stmt->error);
}