<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("cnx.php");
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die('Accès refusé : seuls les administrateurs peuvent ajouter des recettes.');
}
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Erreur : Utilisateur non connecté.'); window.history.back();</script>";
    exit();
}
$user_id = $_SESSION['id'];
if (
    !isset(
    $_POST['recipe-name'],
    $_POST['recipe-category'],
    $_POST['recipe-ingredients'],
    $_POST['recipe-preparation'],
    $_POST['preparation-time'],
    $_POST['cooking-time'],
    $_POST['servings'],
    $_FILES['recipe-image']
)
) {
    echo "<script>alert('Erreur : Tous les champs du formulaire doivent être remplis.'); window.history.back();</script>";
    exit();
}
$recipe_name = $_POST['recipe-name'];
$recipe_cat = $_POST['recipe-category'];
$recipe_ingredients = $_POST['recipe-ingredients'];
$recipe_preparation = $_POST['recipe-preparation'];
$preparation_time = intval($_POST['preparation-time']);
$cooking_time = intval($_POST['cooking-time']);
$servings = intval($_POST['servings']);
$nb = $_POST['nb'];
$check_stmt = $cnx->prepare("SELECT id FROM recetts WHERE name = ? AND user_id = ?");
$check_stmt->bind_param("si", $recipe_name, $user_id);
$check_stmt->execute();
$check_stmt->store_result();
if ($check_stmt->num_rows > 0) {
    echo "<script>alert('Erreur : Une recette avec ce nom existe déjà dans votre collection.'); window.history.back();</script>";
    $check_stmt->close();
    exit();
}
$check_stmt->close();
$target_dir = "uploads/";
$unique_filename = uniqid() . '_' . basename($_FILES["recipe-image"]["name"]);
$target_file = $target_dir . $unique_filename;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0755, true)) {
        echo "<script>alert('Erreur : Impossible de créer le dossier uploads.'); window.history.back();</script>";
        exit();
    }
}
if ($_FILES['recipe-image']['error'] !== UPLOAD_ERR_OK) {
    echo "<script>alert('Erreur lors de l\\'upload du fichier : " . $_FILES['recipe-image']['error'] . "'); window.history.back();</script>";
    exit();
}
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($imageFileType, $allowed_types)) {
    echo "<script>alert('Erreur : Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.'); window.history.back();</script>";
    exit();
}
$check = getimagesize($_FILES["recipe-image"]["tmp_name"]);
if ($check === false) {
    echo "<script>alert('Erreur : Le fichier n\\'est pas une image.'); window.history.back();</script>";
    exit();
}
if ($_FILES["recipe-image"]["size"] > 5 * 1024 * 1024) {
    echo "<script>alert('Erreur : Le fichier est trop volumineux. La taille maximale autorisée est de 5 Mo.'); window.history.back();</script>";
    exit();
}
if (move_uploaded_file($_FILES["recipe-image"]["tmp_name"], $target_file)) {
    $stmt = $cnx->prepare("INSERT INTO recetts (name, cat, ingredients, preparation, preparation_time, cooking_time, servings, image_path, user_id,nb) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
    if (!$stmt) {
        echo "<script>alert('Erreur de préparation de la requête : " . $cnx->error . "'); window.history.back();</script>";
        exit();
    }
    $stmt->bind_param("ssssiiisss", $recipe_name, $recipe_cat, $recipe_ingredients, $recipe_preparation, $preparation_time, $cooking_time, $servings, $target_file, $user_id, $nb);
    if ($stmt->execute()) {
        echo "<script>alert('Recette ajoutée avec succès !'); window.location.href = '../main.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\\'ajout de la recette : " . $stmt->error . "'); window.history.back();</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Erreur : Impossible de déplacer le fichier uploadé.'); window.history.back();</script>";
    exit();
}
$cnx->close();
?>