<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("cnx.php");
session_start();
if (!isset($_SESSION['id'])) {
    echo "<script>alert('Erreur : Utilisateur non connecté.'); window.history.back();</script>";
    exit();
}
$user_id = $_SESSION['id'];
if (
    !isset(
    $_POST['recipe-name'],
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
$recipe_ingredients = $_POST['recipe-ingredients'];
$recipe_preparation = $_POST['recipe-preparation'];
$preparation_time = intval($_POST['preparation-time']);
$cooking_time = intval($_POST['cooking-time']);
$servings = intval($_POST['servings']);
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["recipe-image"]["name"]);
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
    $stmt = $cnx->prepare("INSERT INTO recetts (name, ingredients, preparation, preparation_time, cooking_time, servings, image_path, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "<script>alert('Erreur de préparation de la requête : " . $cnx->error . "'); window.history.back();</script>";
        exit();
    }
    $stmt->bind_param("sssiiiss", $recipe_name, $recipe_ingredients, $recipe_preparation, $preparation_time, $cooking_time, $servings, $target_file, $user_id);
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