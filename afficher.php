<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include("php/cnx.php");
$query = "SELECT name, ingredients, preparation, image_path, preparation_time, cooking_time, servings FROM recetts";
$result = $cnx->query($query);
if ($result->num_rows === 0) {
    echo "<p>Aucune recette trouvée.</p>";
    exit();
}
$cnx->close();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des recettes</title>
    <link rel="stylesheet" href="css/afficher.css">
    <script src="https://kit.fontawesome.com/0b6d538c32.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../../images/logo.png">
</head>

<body>
    <header>
        <div class="logo">
            <h1><strong>Liste des recettes</strong></h1>
        </div>
    </header>
    <main>
        <?php while ($recipe = $result->fetch_assoc()): ?>
            <div class="recipe-card">
                <div class="recipe-header">
                    <h2><?php echo htmlspecialchars($recipe['name']); ?></h2>
                    <img src="<?php echo htmlspecialchars($recipe['image_path']); ?>"
                        alt="<?php echo htmlspecialchars($recipe['name']); ?>">
                </div>
                <div class="recipe-details">
                    <p><strong>Temps de préparation :</strong> <?php echo htmlspecialchars($recipe['preparation_time']); ?>
                        min</p>
                    <p><strong>Temps de cuisson :</strong> <?php echo htmlspecialchars($recipe['cooking_time']); ?> min</p>
                    <p><strong>Nombre des Portions :</strong> <?php echo htmlspecialchars($recipe['servings']); ?> Portions
                    </p>
                </div>
                <div class="recipe-content">
                    <div class="ingredients">
                        <h3>Ingrédients</h3>
                        <ul>
                            <?php
                            $ingredients = explode("\n", $recipe['ingredients']);
                            foreach ($ingredients as $ingredient) {
                                echo "<li>" . htmlspecialchars(trim($ingredient)) . "</li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="preparation">
                        <h3>Préparation</h3>
                        <ol>
                            <?php
                            $steps = explode("\n", $recipe['preparation']);
                            foreach ($steps as $step) {
                                echo "<li>" . htmlspecialchars(trim($step)) . "</li>";
                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </main>
</body>

</html>