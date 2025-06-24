<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("cnx.php");

// Récupération des champs du formulaire
$recipe_name = isset($_POST['recipe_name']) ? trim($_POST['recipe_name']) : '';
$ingredients = isset($_POST['ingredients']) ? trim($_POST['ingredients']) : '';
$category = isset($_POST['category']) ? trim($_POST['category']) : '';
$prep_time_max = isset($_POST['prep_time_max']) ? intval($_POST['prep_time_max']) : 0;
$difficulty = isset($_POST['difficulty']) ? trim($_POST['difficulty']) : '';

// Construction dynamique de la requête
$query = "SELECT * FROM recetts WHERE 1=1";
$params = [];
$types = '';

if ($recipe_name !== '') {
    $query .= " AND name LIKE ?";
    $params[] = "%$recipe_name%";
    $types .= 's';
}
if ($ingredients !== '') {
    $ings = array_map('trim', explode(',', $ingredients));
    foreach ($ings as $ing) {
        $query .= " AND ingredients LIKE ?";
        $params[] = "%$ing%";
        $types .= 's';
    }
}
if ($category !== '') {
    $query .= " AND categorie = ?";
    $params[] = $category;
    $types .= 's';
}
if ($prep_time_max > 0) {
    $query .= " AND preparation_time <= ?";
    $params[] = $prep_time_max;
    $types .= 'i';
}
if ($difficulty !== '') {
    $query .= " AND difficulte = ?";
    $params[] = $difficulty;
    $types .= 's';
}

$stmt = $cnx->prepare($query);
if (!$stmt) {
    die("Erreur de préparation de la requête : " . $cnx->error);
}
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

?><!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Résultats de la recherche</title>
    <link rel="stylesheet" href="../css/style_f_r.css">
    <link rel="shortcut icon" href="../images/logo.jpg">
</head>

<body>
    <nav aria-label="Navigation principale">
        <div class="logo">SMART CHEF</div>
        <ul class="nav-links">
            <li><a href="../index.html">Accueil</a></li>
            <li><a href="../about.html">À propos</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <button class="btn" onclick="window.location.href='../Connexion.php'" aria-label="Connexion">
            <i class="fas fa-user" aria-hidden="true"></i> Connexion
        </button>
        <button class="hamburger" aria-label="Ouvrir le menu" aria-controls="nav-menu" aria-expanded="false"
            onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </button>
    </nav>
    <ul class="nav-links-mobile" id="nav-menu" hidden>
        <li><a href="../index.html">Accueil</a></li>
        <li><a href="../about.html">À propos</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="../Connexion.php">Connexion</a></li>
    </ul>
    <script>
        function toggleMenu() {
            const nav = document.getElementById('nav-menu');
            const btn = document.querySelector('.hamburger');
            const expanded = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', !expanded);
            nav.hidden = expanded;
        }
    </script>
    <main>
        <h1>Résultats de la recherche</h1>
        <?php if ($result->num_rows === 0): ?>
            <p>Aucune recette trouvée avec ces critères.</p>
        <?php else: ?>
            <div class="recettes-list">
                <?php while ($recette = $result->fetch_assoc()): ?>
                    <div class="recette">
                        <h2><?= htmlspecialchars($recette['name']) ?></h2>
                        <?php if (!empty($recette['image_path'])): ?>
                            <img src="../php/uploads/<?= htmlspecialchars($recette['image_path']) ?>"
                                alt="<?= htmlspecialchars($recette['name']) ?>" style="max-width:200px;">
                        <?php endif; ?>
                        <p><strong>Catégorie :</strong> <?= htmlspecialchars($recette['categorie']) ?></p>
                        <p><strong>Temps de préparation :</strong> <?= htmlspecialchars($recette['preparation_time']) ?> min</p>
                        <p><strong>Difficulté :</strong> <?= htmlspecialchars($recette['difficulte']) ?></p>
                        <h3>Ingrédients :</h3>
                        <ul>
                            <?php foreach (explode("\n", $recette['ingredients']) as $ing): ?>
                                <?php if (!empty(trim($ing))): ?>
                                    <li><?= htmlspecialchars(trim($ing)) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                        <a href="../advanced.php?id=<?= $recette['id'] ?>" class="btn">Voir la recette</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </main>
    <footer id="contact" aria-label="Pied de page">
        <div class="footer-logo">
            <i class="icofont-chef" aria-hidden="true"></i> Smart Chef
        </div>
        <div class="footer-links">
            <a href="#">Mentions légales</a> |
            <a href="#">Politique de confidentialité</a> |
            <a href="#">Contact</a>
        </div>
        <div class="social-links">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
            <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
        <p>L'assistant culinaire intelligent qui révolutionne votre façon de cuisiner</p>
        <div class="copyright">
            &copy; 2025 Smart Chef. Tous droits réservés.
        </div>
    </footer>
</body>

</html>