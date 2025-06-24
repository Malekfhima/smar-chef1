<?php
include "php/cnx.php";
session_start();
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index1.php");
    exit();
}
$recipe_id = mysqli_real_escape_string($cnx, $_GET['id']);
$stmt = mysqli_prepare($cnx, "SELECT * FROM recetts WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $recipe_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) === 0) {
    header("Location: recc.php");
    exit();
}
$recipe = mysqli_fetch_assoc($result);
$title = htmlspecialchars($recipe['name']);
$image_path = 'php/uploads/' . htmlspecialchars(basename($recipe['image_path']));
$prep_time = htmlspecialchars($recipe['preparation_time']);
$cook_time = htmlspecialchars($recipe['cooking_time']);
$servings = htmlspecialchars($recipe['servings']);
$ingredients = $recipe['ingredients'];
$instructions = $recipe['preparation'];
$notes = $recipe['nb'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Détail d'une recette Smart Chef : ingrédients, préparation, avis, note, favoris et plus.">
    <meta name="keywords" content="recette, détail, ingrédients, préparation, avis, note, favoris, smart chef, cuisine">
    <link rel="stylesheet" href="css/style_f_r.css">
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="images/logo.jpg">
    <style>
        .ingredients ol,
        .preparation ol,
        .notes ol {
            padding-left: 2rem;
        }

        .ingredients li,
        .preparation li,
        .notes li {
            margin-bottom: 8px;
            list-style-type: decimal;
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
    <ul class="nav-links-mobile" id="nav-menu" hidden aria-label="Menu mobile">
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
    <section id="home">
        <h1><?= $title ?></h1>
        <?php
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            // Vérifier si la recette est déjà dans les favoris
            $fav_stmt = $cnx->prepare("SELECT 1 FROM user_favoris WHERE user_id = ? AND recette_id = ?");
            $fav_stmt->bind_param("ii", $user_id, $recipe_id);
            $fav_stmt->execute();
            $is_fav = $fav_stmt->get_result()->num_rows > 0;
            $fav_stmt->close();
            if ($is_fav) {
                echo '<form action="php/favoris.php" method="POST" style="display:inline;">';
                echo '<input type="hidden" name="recette_id" value="' . $recipe_id . '">';
                echo '<input type="hidden" name="action" value="remove">';
                echo '<button type="submit" class="btn" style="background:#e74c3c;">Retirer des favoris ★</button>';
                echo '</form>';
            } else {
                echo '<form action="php/favoris.php" method="POST" style="display:inline;">';
                echo '<input type="hidden" name="recette_id" value="' . $recipe_id . '">';
                echo '<input type="hidden" name="action" value="add">';
                echo '<button type="submit" class="btn">Ajouter aux favoris ☆</button>';
                echo '</form>';
            }
        } else {
            echo '<p><a href="Connexion.php" class="btn">Connectez-vous pour ajouter aux favoris</a></p>';
        }
        ?>
    </section>
    <section id="recipes">
        <div class="recipe-card">
            <div class="recipe-header">
                <img src="<?= $image_path ?>" alt="Photo de la recette <?= $title ?>" style="border-radius: 2%;">
            </div>
            <div class="recipe-details">
                <h3>Détails</h3>
                <p><strong>Temps de préparation :</strong> <?= $prep_time ?> Minutes.</p>
                <p><strong>Temps de cuisson :</strong> <?= $cook_time ?> Minutes.</p>
                <p><strong>Portions :</strong> <?= $servings ?> Portions.</p>
            </div>
            <div class="recipe-content">
                <div class="ingredients">
                    <h3>Ingrédients</h3>
                    <ol>
                        <?php
                        $ingredients_list = preg_split('/\r\n|\r|\n/', trim($ingredients));
                        foreach ($ingredients_list as $ingredient) {
                            if (!empty(trim($ingredient))) {
                                echo '<li>' . htmlspecialchars(trim($ingredient)) . '</li>';
                            }
                        }
                        ?>
                    </ol>
                </div>
                <div class="preparation">
                    <h3>Préparation</h3>
                    <ol>
                        <?php
                        $steps = preg_split('/\r\n|\r|\n/', trim($instructions));
                        foreach ($steps as $step) {
                            if (!empty(trim($step))) {
                                echo '<li>' . htmlspecialchars(trim($step)) . '</li>';
                            }
                        }
                        ?>
                    </ol>
                </div>
                <?php if (!empty(trim($notes))): ?>
                    <div class="notes">
                        <h3>Note Bien</h3>
                        <ol>
                            <?php
                            $notes_list = preg_split('/\r\n|\r|\n/', trim($notes));
                            foreach ($notes_list as $note) {
                                if (!empty(trim($note))) {
                                    echo '<li>' . htmlspecialchars(trim($note)) . '</li>';
                                }
                            }
                            ?>
                        </ol>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section id="avis">
        <?php
        // Connexion à la base déjà faite plus haut
// 1. Affichage de la note moyenne et du nombre d'avis
        $avis_stmt = $cnx->prepare("SELECT AVG(note) as moyenne, COUNT(*) as nb FROM recette_avis WHERE recette_id = ?");
        $avis_stmt->bind_param("i", $recipe_id);
        $avis_stmt->execute();
        $avis_result = $avis_stmt->get_result()->fetch_assoc();
        $moyenne = $avis_result['moyenne'] ? round($avis_result['moyenne'], 1) : '–';
        $nb_avis = $avis_result['nb'];
        $avis_stmt->close();
        ?>
        <div class="note-moyenne">
            <h3>Note moyenne :</h3>
            <div style="font-size:2rem;color:#FAB800;">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <?php if ($moyenne >= $i): ?><span>★</span><?php else: ?><span
                            style="color:#ccc">★</span><?php endif; ?>
                <?php endfor; ?>
                <span style="font-size:1rem;color:#333;">(<?= $moyenne ?>/5, <?= $nb_avis ?> avis)</span>
            </div>
        </div>

        <?php
        // 2. Affichage des avis
        $avis_list_stmt = $cnx->prepare("SELECT user, note, commentaire, date_avis FROM recette_avis WHERE recette_id = ? ORDER BY date_avis DESC");
        $avis_list_stmt->bind_param("i", $recipe_id);
        $avis_list_stmt->execute();
        $avis_list = $avis_list_stmt->get_result();
        ?>
        <div class="avis-list">
            <h3>Avis des utilisateurs :</h3>
            <?php if ($avis_list->num_rows === 0): ?>
                <p>Soyez le premier à donner votre avis !</p>
            <?php else: ?>
                <?php while ($avis = $avis_list->fetch_assoc()): ?>
                    <div class="avis-item" style="border-bottom:1px solid #eee;margin-bottom:1em;">
                        <strong><?= htmlspecialchars($avis['user'] ?: 'Anonyme') ?></strong>
                        <span style="color:#FAB800;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($avis['note'] >= $i): ?><span>★</span><?php else: ?><span
                                        style="color:#ccc">★</span><?php endif; ?>
                            <?php endfor; ?>
                        </span>
                        <em style="color:#888;font-size:0.9em;">le <?= date('d/m/Y', strtotime($avis['date_avis'])) ?></em>
                        <div><?= nl2br(htmlspecialchars($avis['commentaire'])) ?></div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <?php $avis_list_stmt->close(); ?>

        <!-- 3. Formulaire d'avis -->
        <div class="avis-form" style="margin-top:2em;">
            <h3>Laisser un avis :</h3>
            <form action="php/avis.php" method="POST">
                <input type="hidden" name="recette_id" value="<?= $recipe_id ?>">
                <label for="user">Votre nom (optionnel) :</label>
                <input type="text" id="user" name="user" maxlength="100">
                <label for="note">Note :</label>
                <select id="note" name="note" required>
                    <option value="">-- Choisir --</option>
                    <option value="1">1 ★</option>
                    <option value="2">2 ★★</option>
                    <option value="3">3 ★★★</option>
                    <option value="4">4 ★★★★</option>
                    <option value="5">5 ★★★★★</option>
                </select>
                <label for="commentaire">Commentaire :</label>
                <textarea id="commentaire" name="commentaire" rows="3" required></textarea>
                <button type="submit" class="btn">Envoyer</button>
            </form>
        </div>
    </section>
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