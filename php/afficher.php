<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("cnx.php");
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die('Accès refusé : seuls les administrateurs peuvent modifier ou supprimer des recettes.');
}
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
    $query = "SELECT name, ingredients, preparation, image_path, preparation_time, cooking_time, servings 
              FROM recetts 
              WHERE ingredients LIKE ?";
    $stmt = $cnx->prepare($query);
    if (!$stmt) {
        throw new Exception("Erreur de préparation de la requête : " . $cnx->error);
    }
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
    $recipes = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $cnx->close();
} catch (Exception $e) {
    echo "<script>
        Swal.fire({
            title: 'Erreur',
            text: '" . addslashes($e->getMessage()) . "',
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
    <link rel="stylesheet" href="../css/style_f_r.css">
    <script src="https://kit.fontawesome.com/0b6d538c32.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="../images/logo.jpg">
    <style>
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <?php
        include("../nav.php");
        ?>
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
                        alt="<?php echo htmlspecialchars($recipe['name']); ?>" style="height: 500px;">
                </div>
                <div class="recipe-details">
                    <h3>Details</h3>
                    <p><strong>Temps de préparation :</strong> <?php echo htmlspecialchars($recipe['preparation_time']); ?>
                        Minutes.</p>
                    <p><strong>Temps de cuisson :</strong> <?php echo htmlspecialchars($recipe['cooking_time']); ?> Minutes.
                    </p>
                    <p><strong>Nombre de portions :</strong> <?php echo htmlspecialchars($recipe['servings']); ?> Portions.
                    </p>
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