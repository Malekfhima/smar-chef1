<?php
include "php/cnx.php";
session_start();

// Vérifier si l'ID de la recette existe
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index1.php");
    exit();
}

// Récupérer et sécuriser l'ID
$recipe_id = mysqli_real_escape_string($cnx, $_GET['id']);

// Requête préparée pour la sécurité
$stmt = mysqli_prepare($cnx, "SELECT * FROM recetts WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $recipe_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Vérifier si la recette existe
if(mysqli_num_rows($result) === 0) {
    header("Location: recc.php");
    exit();
}

$recipe = mysqli_fetch_assoc($result);

// Préparation des données
$title = htmlspecialchars($recipe['name']);
$image_path = 'php/uploads/' . htmlspecialchars(basename($recipe['image_path']));
$prep_time = htmlspecialchars($recipe['preparation_time']);
$cook_time = htmlspecialchars($recipe['cooking_time']);
$servings = htmlspecialchars($recipe['servings']);
$ingredients = nl2br(htmlspecialchars($recipe['ingredients']));
$instructions = nl2br(htmlspecialchars($recipe['preparation']));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_f_r.css">
    <title><?= $title ?></title>
</head>
<body>
    <header>
        <?php include "nav.php"; ?>
    </header>

    <section id="home">
        <h1><?= $title ?></h1>
    </section>

    <section id="recipes">
        <div class="recipe-card">
            <div class="recipe-header">
                <img src="<?= $image_path ?>" alt="<?= $title ?>" style="border-radius: 2%;">
            </div>
            
            <div class="recipe-details">
                <h3>Détails</h3>
                <p><strong>Temps de préparation :</strong> <?= $prep_time ?></p>
                <p><strong>Temps de cuisson :</strong> <?= $cook_time ?></p>
                <p><strong>Portions :</strong> <?= $servings ?></p>
            </div>

            <div class="recipe-content">
                <div class="ingredients">
                    <h3>Ingrédients</h3>
                    <ul>
                        <?php
                        // Convertir les ingrédients en liste
                        $ingredients_list = explode("\n", trim($recipe['ingredients']));
                        foreach($ingredients_list as $ingredient) {
                            if(!empty(trim($ingredient))) {
                                echo '<li>' . htmlspecialchars(trim($ingredient)) . '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>

                <div class="preparation">
                    <h3>Préparation</h3>
                    <ol>
                        <?php
                        // Convertir les étapes en liste numérotée
                        $steps = explode("\n", trim($recipe['preparation']));
                        foreach($steps as $step) {
                            if(!empty(trim($step))) {
                                echo '<li>' . htmlspecialchars(trim($step)) . '</li>';
                            }
                        }
                        ?>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <?php include "footer.php"; ?>
    </footer>
</body>
</html>