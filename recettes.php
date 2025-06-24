<?php
session_start();
include("php/cnx.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['resultats_recherche'])) {
    die("Aucune donnée disponible. Retour à <a href='index1.php'>l'accueil</a>.");
}
$donnees = $_SESSION['resultats_recherche'];
unset($_SESSION['resultats_recherche']);
echo "<pre>Données session: ";
print_r($donnees);
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="fr">
<link rel="shortcut icon" href="images/logo.jpg">

<head>
    <meta charset="UTF-8">
    <style>
        .recette {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px;
        }

        img {
            max-width: 200px;
        }
    </style>
</head>

<body>
    <nav aria-label="Navigation principale">
        <div class="logo">SMART CHEF</div>
        <ul class="nav-links">
            <li><a href="index.html">Accueil</a></li>
            <li><a href="about.html">À propos</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="mes_favoris.php">Mes Favoris</a></li>
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
        <li><a href="mes_favoris.php">Mes Favoris</a></li>
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
    <h1>Catégorie: <?= htmlspecialchars($donnees['categorie'] ?? 'Inconnue') ?></h1>
    <?php if (empty($donnees['recettes'])): ?>
        <p>Aucune recette trouvée</p>
    <?php else: ?>
        <?php foreach ($donnees['recettes'] as $recette): ?>
            <div class="recette">
                <h2><?= htmlspecialchars($recette['name'] ?? 'Nom inconnu') ?></h2>
                <?php if (!empty($recette['image_path'])): ?>
                    <img src="<?= htmlspecialchars($recette['image_path']) ?>"
                        alt="<?= htmlspecialchars($recette['name'] ?? '') ?>">
                <?php endif; ?>
                <p>Temps: <?= $recette['temps_preparation'] ?? '?' ?> min</p>
                <h3>Ingrédients:</h3>
                <ul>
                    <?php foreach (explode("\n", $recette['ingredients'] ?? '') as $ing): ?>
                        <?php if (!empty(trim($ing))): ?>
                            <li><?= htmlspecialchars(trim($ing)) ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
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
    <div id="cookie-banner"
        style="position:fixed;bottom:0;left:0;width:100%;background:#222;color:#fff;padding:1em;text-align:center;z-index:9999;display:none;">
        Ce site utilise des cookies pour améliorer votre expérience. <a href="politique_confidentialite.html"
            style="color:#FAB800;text-decoration:underline;">En savoir plus</a>.
        <button onclick="acceptCookies()" style="margin-left:1em;" class="btn">Accepter</button>
        <button onclick="refuseCookies()" style="margin-left:0.5em;background:#e74c3c;" class="btn">Refuser</button>
    </div>
    <script>
        function acceptCookies() {
            localStorage.setItem('cookiesAccepted', '1');
            document.getElementById('cookie-banner').style.display = 'none';
        }
        function refuseCookies() {
            localStorage.setItem('cookiesAccepted', '0');
            document.getElementById('cookie-banner').style.display = 'none';
        }
        window.onload = function () {
            if (localStorage.getItem('cookiesAccepted') === null) {
                document.getElementById('cookie-banner').style.display = 'block';
            }
        }
    </script>
</body>

</html>