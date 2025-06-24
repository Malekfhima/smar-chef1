<?php
session_start();
include("php/cnx.php");
if (!isset($_SESSION['user_id'])) {
    header('Location: Connexion.php');
    exit();
}
$user_id = intval($_SESSION['user_id']);
$stmt = $cnx->prepare("SELECT r.id, r.name, r.image_path, r.categorie FROM recetts r INNER JOIN user_favoris f ON r.id = f.recette_id WHERE f.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mes Favoris</title>
    <link rel="stylesheet" href="css/style_f_r.css">
    <link rel="shortcut icon" href="images/logo.jpg">
</head>

<body>
    <nav aria-label="Navigation principale">
        <div class="logo">SMART CHEF</div>
        <ul class="nav-links">
            <li><a href="index.html">Accueil</a></li>
            <li><a href="about.html">À propos</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="mes_favoris.php" class="active">Mes Favoris</a></li>
        </ul>
        <button class="btn" onclick="window.location.href='Connexion.php'" aria-label="Connexion">
            <i class="fas fa-user" aria-hidden="true"></i> Connexion
        </button>
        <button class="hamburger" aria-label="Ouvrir le menu" aria-controls="nav-menu" aria-expanded="false"
            onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </button>
    </nav>
    <ul class="nav-links-mobile" id="nav-menu" hidden>
        <li><a href="index.html">Accueil</a></li>
        <li><a href="about.html">À propos</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="mes_favoris.php" class="active">Mes Favoris</a></li>
        <li><a href="Connexion.php">Connexion</a></li>
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
        <h1>Mes recettes favorites</h1>
        <?php if ($result->num_rows === 0): ?>
            <p>Vous n'avez pas encore de recettes en favoris.</p>
        <?php else: ?>
            <div class="recettes-list">
                <?php while ($recette = $result->fetch_assoc()): ?>
                    <div class="recette">
                        <h2><a href="advanced.php?id=<?= $recette['id'] ?>"><?= htmlspecialchars($recette['name']) ?></a></h2>
                        <?php if (!empty($recette['image_path'])): ?>
                            <img src="php/uploads/<?= htmlspecialchars($recette['image_path']) ?>"
                                alt="<?= htmlspecialchars($recette['name']) ?>" style="max-width:200px;">
                        <?php endif; ?>
                        <p><strong>Catégorie :</strong> <?= htmlspecialchars($recette['categorie']) ?></p>
                        <form action="php/favoris.php" method="POST" style="margin-top:1em;">
                            <input type="hidden" name="recette_id" value="<?= $recette['id'] ?>">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="btn" style="background:#e74c3c;">Retirer des favoris ★</button>
                        </form>
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
<?php $stmt->close(); ?>