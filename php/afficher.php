<?php
// php/afficher.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include("cnx.php");

// Vérifier si un ingrédient a été soumis
if (!isset($_POST['nom']) || empty(trim($_POST['nom']))) {
    echo "<script>
        Swal.fire({
            title: 'Erreur',
            text: 'Aucun ingrédient spécifié',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.history.back();
        });
    </script>";
    exit();
}

$ingredient = trim($_POST['nom']);

try {
    // Préparer la requête pour chercher les recettes contenant l'ingrédient
    $query = "SELECT name, ingredients, preparation, image_path, preparation_time, cooking_time, servings 
              FROM recetts 
              WHERE ingredients LIKE ?";
    $stmt = $cnx->prepare($query);

    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête : " . $cnx->error);
    }

    // Ajouter les wildcards pour la recherche partielle
    $search_term = "%" . $ingredient . "%";
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>
            Swal.fire({
                title: 'Aucun résultat',
                text: 'Aucune recette trouvée contenant cet ingrédient',
                icon: 'info',
                confirmButtonText: 'OK'
            }).then(() => {
                window.history.back();
            });
        </script>";
        exit();
    }

    // Récupérer toutes les recettes
    $recipes = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $cnx->close();
    
} catch (Exception $e) {
    echo "<script>
        Swal.fire({
            title: 'Erreur',
            text: '".addslashes($e->getMessage())."',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recettes contenant <?php echo htmlspecialchars($ingredient); ?></title>
    <link rel="stylesheet" href="../css/afficher.css">
    <link rel="stylesheet" href="../css/style_f_r.css">
    <script src="https://kit.fontawesome.com/0b6d538c32.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="../images/logo.png">
    <style>
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="#recipes">Recipes</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <section id="home">
        <h1>Recettes contenant "<?php echo htmlspecialchars($ingredient); ?>"</h1>
    </section>
    <section id="recipes">
        <?php foreach ($recipes as $recipe): ?>
            <div class="recipe-card">
                <div class="recipe-header">
                    <h2><?php echo htmlspecialchars($recipe['name']); ?></h2>
                    <img src="<?php echo htmlspecialchars($recipe['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($recipe['name']); ?>">
                </div>
                <div class="recipe-details">
                    <p><strong>Temps de préparation :</strong> <?php echo htmlspecialchars($recipe['preparation_time']); ?> min</p>
                    <p><strong>Temps de cuisson :</strong> <?php echo htmlspecialchars($recipe['cooking_time']); ?> min</p>
                    <p><strong>Nombre de portions :</strong> <?php echo htmlspecialchars($recipe['servings']); ?> portions</p>
                </div>
                <div class="recipe-content">
                    <div class="ingredients">
                        <h3>Ingrédients</h3>
                        <ul>
                            <?php
                            $ingredients = explode("\n", $recipe['ingredients']);
                            foreach ($ingredients as $ing) {
                                $highlighted = preg_replace(
                                    "/(" . preg_quote($ingredient, '/') . ")/i", 
                                    '<span class="highlight">$1</span>', 
                                    htmlspecialchars(trim($ing))
                                );
                                echo "<li>" . $highlighted . "</li>";
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
        <?php endforeach; ?>
    </section>
    <footer>
        <p>&copy; 2025 SmartChef. All rights reserved.</p>
    </footer>
</body>
</html>