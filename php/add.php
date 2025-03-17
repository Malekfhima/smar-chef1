<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure le fichier de connexion à la base de données
include("cnx.php");

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Erreur : Utilisateur non connecté.'); window.history.back();</script>";
    exit();
}

// Récupérer l'ID de l'utilisateur
$user_id = $_SESSION['id'];

// Vérifier que tous les champs du formulaire sont remplis
if (!isset($_POST['recipe-name'], $_POST['recipe-ingredients'], $_POST['recipe-preparation'], $_FILES['recipe-image'])) {
    echo "<script>alert('Erreur : Tous les champs du formulaire doivent être remplis.'); window.history.back();</script>";
    exit();
}

// Récupérer les données du formulaire
$recipe_name = $_POST['recipe-name'];
$recipe_ingredients = $_POST['recipe-ingredients'];
$recipe_preparation = $_POST['recipe-preparation'];

// Gestion de l'upload de l'image
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["recipe-image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Vérifier si le dossier 'uploads' existe, sinon le créer
if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0755, true)) {
        echo "<script>alert('Erreur : Impossible de créer le dossier uploads.'); window.history.back();</script>";
        exit();
    }
}

// Vérifier les erreurs d'upload
if ($_FILES['recipe-image']['error'] !== UPLOAD_ERR_OK) {
    echo "<script>alert('Erreur lors de l\\'upload du fichier : " . $_FILES['recipe-image']['error'] . "'); window.history.back();</script>";
    exit();
}

// Vérifier le type de fichier
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($imageFileType, $allowed_types)) {
    echo "<script>alert('Erreur : Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.'); window.history.back();</script>";
    exit();
}

// Vérifier si le fichier est une image
$check = getimagesize($_FILES["recipe-image"]["tmp_name"]);
if ($check === false) {
    echo "<script>alert('Erreur : Le fichier n\\'est pas une image.'); window.history.back();</script>";
    exit();
}

// Vérifier la taille du fichier
if ($_FILES["recipe-image"]["size"] > 5 * 1024 * 1024) {
    echo "<script>alert('Erreur : Le fichier est trop volumineux. La taille maximale autorisée est de 5 Mo.'); window.history.back();</script>";
    exit();
}

// Déplacer le fichier uploadé
if (move_uploaded_file($_FILES["recipe-image"]["tmp_name"], $target_file)) {
    // Préparer la requête SQL pour insérer la recette
    $stmt = $cnx->prepare("INSERT INTO recetts (name, ingredients, preparation, image_path, user_id) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "<script>alert('Erreur de préparation de la requête : " . $cnx->error . "'); window.history.back();</script>";
        exit();
    }

    // Lier les paramètres à la requête
    $stmt->bind_param("ssssi", $recipe_name, $recipe_ingredients, $recipe_preparation, $target_file, $user_id);

    // Exécuter la requête
    if ($stmt->execute()) {
        sleep(1);
        echo "<script>alert('Recette ajoutée avec succès !'); window.location.href = '../main.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\\'ajout de la recette : " . $stmt->error . "'); window.history.back();</script>";
    }

    // Fermer la requête
    $stmt->close();
} else {
    echo "<script>alert('Erreur : Impossible de déplacer le fichier uploadé.'); window.history.back();</script>";
    exit();
}

// Fermer la connexion à la base de données
$cnx->close();
?>