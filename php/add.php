<?php
include("cnx.php");
session_start();
extract($_POST);
if (!isset($_POST['recipe-name'], $_POST['recipe-ingredients'], $_POST['recipe-preparation'], $_FILES['recipe-image'])) {
    die("Erreur : Tous les champs du formulaire doivent être remplis.");
}
$recipe_name = $_POST['recipe-name'];
$recipe_ingredients = $_POST['recipe-ingredients'];
$recipe_preparation = $_POST['recipe-preparation'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["recipe-image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
if (!is_dir($target_dir)) {
    if (!mkdir($target_dir, 0755, true)) {
        die("Erreur : Impossible de créer le dossier 'uploads'.");
    }
}
if ($_FILES['recipe-image']['error'] !== UPLOAD_ERR_OK) {
    die("Erreur lors de l'upload du fichier : " . $_FILES['recipe-image']['error']);
}
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($imageFileType, $allowed_types)) {
    die("Erreur : Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.");
}
$check = getimagesize($_FILES["recipe-image"]["tmp_name"]);
if ($check === false) {
    die("Erreur : Le fichier n'est pas une image.");
}
if ($_FILES["recipe-image"]["size"] > 5 * 1024 * 1024) {
    die("Erreur : Le fichier est trop volumineux. La taille maximale autorisée est de 5 Mo.");
}
if (move_uploaded_file($_FILES["recipe-image"]["tmp_name"], $target_file)) {
    $stmt = $cnx->prepare("INSERT INTO recetts (name, ingredients, preparation, image_path) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Erreur de préparation de la requête : " . $cnx->error);
    }
    $stmt->bind_param("ssss", $recipe_name, $recipe_ingredients, $recipe_preparation, $target_file);
    if ($stmt->execute()) {
        echo "<script>alert(Recette ajoutée avec succès !);</script>";
    } else {
        echo "<script></script>alert(Erreur lors de l'ajout de la recette : " . $stmt->error . ");</script>";
    }
    $stmt->close();
} else {
    die("Erreur : Impossible de déplacer le fichier uploadé.");
}
$cnx->close();
?>