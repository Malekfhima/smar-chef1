<?php

include("php/cnx.php");
session_start();

if (!isset($_POST['id'])) {
    header("Location: index1.php");
    exit();
}

$recipe_id = intval($_POST['id']);
$query = "SELECT * FROM recetts WHERE id = ?";
$stmt = $cnx->prepare($query);
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$recipe = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$recipe) {
    header("Location: index1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recipe['name']) ?></title>
    <style>
        body {
            font-family: 'Advent Pro', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h1 {
            font-family: 'Dancing Script', cursive;
            color: #0258A5;
            margin-bottom: 20px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #0258A5;
            text-decoration: none;
        }
        .recipe-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .recipe-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
            color: #666;
        }
        .recipe-section {
            margin-bottom: 25px;
        }
        .recipe-section h2 {
            color: #0258A5;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index1.php?category=<?= urlencode($recipe['cat']) ?>" class="back-link">← Retour aux recettes <?= htmlspecialchars($recipe['cat']) ?></a>
        
        <h1><?= htmlspecialchars($recipe['name']) ?></h1>
        
        <img src="<?= htmlspecialchars($recipe['image_path']) ?>" alt="<?= htmlspecialchars($recipe['name']) ?>" class="recipe-image">
        
        <div class="recipe-meta">
            <span>Catégorie: <?= htmlspecialchars($recipe['cat']) ?></span>
            <span>Préparation: <?= $recipe['preparation_time'] ?> min</span>
            <span>Cuisson: <?= $recipe['cooking_time'] ?> min</span>
            <span>Portions: <?= $recipe['servings'] ?></span>
        </div>
        
        <div class="recipe-section">
            <h2>Ingrédients</h2>
            <p><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
        </div>
        
        <div class="recipe-section">
            <h2>Préparation</h2>
            <p><?= nl2br(htmlspecialchars($recipe['preparation'])) ?></p>
        </div>
    </div>
</body>
</html>