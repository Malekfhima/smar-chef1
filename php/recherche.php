<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("cnx.php");
if (!isset($_POST['recipe_name'])) {
    die("Erreur : Aucun nom de recette spécifié.");
}
$recipe_name = trim($_POST['recipe_name']);
$query = "SELECT * FROM recetts WHERE name LIKE ?";
$stmt = $cnx->prepare($query);
if (!$stmt) {
    die("Erreur de préparation de la requête : " . $cnx->error);
}
$search_term = "%" . $recipe_name . "%";
$stmt->bind_param("s", $search_term);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Erreur : Aucune recette trouvée avec ce nom.");
    
}
$recipe = $result->fetch_assoc();
$stmt->close();
$cnx->close();
?>