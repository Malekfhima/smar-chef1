<?php

session_start();
require __DIR__ . '/cnx.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!$cnx || $cnx->connect_error) {
    $_SESSION['erreur'] = "Erreur de connexion à la base de données";
    header('Location: ../index1.php');
    exit();
}
$categorie = filter_input(INPUT_POST, 'cat', FILTER_SANITIZE_STRING);
if (empty($categorie)) {
    $_SESSION['erreur'] = "Aucune catégorie sélectionnée";
    header('Location: ../index1.php');
    exit();
}
try {
    $stmt = $cnx->prepare("SELECT 
        name AS nom,
        ingredients,
        preparation,
        image_path AS image_url,
        preparation_time AS temps_preparation,
        servings AS portions
        FROM  recetts
        WHERE cat = ?");
    if (!$stmt) {
        throw new Exception("Erreur de préparation de requête: " . $cnx->error);
    }
    $stmt->bind_param("s", $categorie);
    if (!$stmt->execute()) {
        throw new Exception("Erreur d'exécution: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $recettes = $result->fetch_all(MYSQLI_ASSOC);
    $_SESSION['resultats_recherche'] = [
        'categorie' => $categorie,
        'recettes' => $recettes
    ];
    $stmt->close();
    $cnx->close();
    header('Location: ../recettes.php');
    exit();
} catch (Exception $e) {
    $_SESSION['erreur'] = "Erreur: " . $e->getMessage();
    header('Location: ../index1.php');
    exit();
}