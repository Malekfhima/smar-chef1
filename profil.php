<?php
session_start();
include("php/cnx.php");
if (!isset($_SESSION['user_id'])) {
    header('Location: Connexion.php');
    exit();
}
$user_id = intval($_SESSION['user_id']);
$stmt = $cnx->prepare("SELECT nom, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nom, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Profil utilisateur Smart Chef : gérez vos informations, changez votre mot de passe et profitez de toutes les fonctionnalités du site.">
    <meta name="keywords"
        content="profil, utilisateur, smart chef, favoris, mot de passe, informations, compte, cuisine">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="css/style_f_r.css">
    <link rel="shortcut icon" href="images/logo.jpg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php if (isset($_GET['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: <?php
                if ($_GET['success'] == 1)
                    echo "'Profil mis à jour avec succès !'";
                elseif ($_GET['success'] == 2)
                    echo "'Mot de passe changé avec succès !'";
                else
                    echo "'Action réussie.'";
                ?>
            });
        </script>
    <?php elseif (isset($_GET['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: <?php
                switch ($_GET['error']) {
                    case 'invalid':
                        echo "'Veuillez remplir tous les champs correctement.'";
                        break;
                    case 'update':
                        echo "'Erreur lors de la mise à jour. Veuillez réessayer.'";
                        break;
                    case 'mdp':
                        echo "'Les mots de passe ne correspondent pas.'";
                        break;
                    case 'old':
                        echo "'L\'ancien mot de passe est incorrect.'";
                        break;
                    default:
                        echo "'Une erreur est survenue.'";
                }
                ?>
            });
        </script>
    <?php endif; ?>
    <nav aria-label="Navigation principale">
        <div class="logo">SMART CHEF</div>
        <ul class="nav-links">
            <li><a href="index.html">Accueil</a></li>
            <li><a href="about.html">À propos</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="mes_favoris.php">Mes Favoris</a></li>
            <li><a href="profil.php" class="active">Mon Profil</a></li>
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
        <li><a href="profil.php" class="active">Mon Profil</a></li>
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
        <h1>Mon Profil</h1>
        <form action="php/update_profil.php" method="POST" style="max-width:400px;margin:auto;"
            aria-label="Formulaire de modification du profil">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom) ?>" required>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            <button type="submit" class="btn">Mettre à jour</button>
        </form>
        <h2 style="margin-top:2em;">Changer de mot de passe</h2>
        <form action="php/update_password.php" method="POST" style="max-width:400px;margin:auto;"
            aria-label="Formulaire de changement de mot de passe">
            <label for="old_password">Mot de passe actuel :</label>
            <input type="password" id="old_password" name="old_password" required>
            <label for="new_password">Nouveau mot de passe :</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit" class="btn">Changer le mot de passe</button>
        </form>
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
<?php $cnx->close(); ?>