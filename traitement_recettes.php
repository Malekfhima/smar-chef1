<?php
// php/traitement_categorie.php
session_start();
require __DIR__ . '/cnx.php';

// Activer le rapport d'erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifier la connexion à la base de données
if (!$cnx || $cnx->connect_error) {
    $_SESSION['erreur'] = "Erreur de connexion à la base de données";
    header('Location: ../index1.php');
    exit();
}

// Récupérer et nettoyer la catégorie
$categorie = filter_input(INPUT_POST, 'cat', FILTER_SANITIZE_STRING);

// Valider la catégorie
if (empty($categorie)) {
    $_SESSION['erreur'] = "Aucune catégorie sélectionnée";
    header('Location: ../index1.php');
    exit();
}

try {
    // Préparer la requête SQL
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

    // Lier les paramètres et exécuter
    $stmt->bind_param("s", $categorie);
    if (!$stmt->execute()) {
        throw new Exception("Erreur d'exécution: " . $stmt->error);
    }

    // Récupérer les résultats
    $result = $stmt->get_result();
    $recettes = $result->fetch_all(MYSQLI_ASSOC);

    // Enregistrer dans la session
    $_SESSION['resultats_recherche'] = [
        'categorie' => $categorie,
        'recettes' => $recettes
    ];

    // Fermer la connexion
    $stmt->close();
    $cnx->close();

    // Redirection
    header('Location: ../recettes.php');
    exit();

} catch (Exception $e) {
    // Gestion des erreurs
    $_SESSION['erreur'] = "Erreur: " . $e->getMessage();
    header('Location: ../index1.php');
    exit();
}