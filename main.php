<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Smart Chef : trouvez, ajoutez et gérez des recettes personnalisées selon vos goûts et ingrédients.">
    <meta name="keywords" content="recette, smart chef, ingrédients, ajouter, recherche, favoris, profil, cuisine">
    <title>SmartChef - Find Recipes</title>
    <link rel="stylesheet" href="assets/css/style_f_r.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="assets/images/logo.jpg">
</head>
<style>
    .user-info {
        margin-right: 15px;
        color: #fff;
        font-weight: bold;
    }

    .main-navigation {
        background-color: #0258A5;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .main-navigation ul {
        display: flex;
        gap: 1.5rem;
        margin: 0;
        padding: 0;
    }

    .main-navigation li {
        list-style: none;
    }

    .main-navigation a {
        color: #fff;
        font-family: 'Advent Pro', sans-serif;
        font-size: 1.2rem;
        font-weight: 500;
        text-decoration: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
    }

    .main-navigation a:hover {
        color: #ffcc00;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .main-navigation a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: #ffcc00;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .main-navigation a:hover::after {
        width: 70%;
    }

    .admin-nav {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .admin-nav span {
        color: #fff;
        font-family: 'Advent Pro', sans-serif;
        font-size: 1.1rem;
        background-color: rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 8px;
    }
</style>

<body>
    <header>
        <?php session_start(); ?>
        <?php include 'nav.php'; ?>
        <button class="hamburger" aria-label="Ouvrir le menu" aria-controls="nav-menu" aria-expanded="false"
            onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </button>
        <ul class="nav-links-mobile" id="nav-menu" hidden aria-label="Menu mobile">
            <li><a href="index.html">Accueil</a></li>
            <li><a href="about.html">À propos</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="mes_favoris.php">Mes Favoris</a></li>
            <li><a href="Connexion.php">Connexion</a></li>
        </ul>
        <script src="assets/js/afficher_pass.js"></script>
    </header>
    <section id="home">
        <?php
        echo '<h1>Bienvenue et bon appétit  ' . $_SESSION['nom'] . ' !</h1>';
        ?>
        <p>Prêt à découvrir de délicieuses recettes? Commencez par saisir vos ingrédients!</p>
    </section>
    <section id="recipes">
        <h3>Ajouter Votre Recette</h3>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <form action="php/add.php" method="POST" enctype="multipart/form-data"
                aria-label="Formulaire d'ajout de recette">
                <label for="recipe-name">Nom de la recette :</label>
                <input type="text" id="recipe-name" name="recipe-name" required>
                <label for="recipe-category">Catégorie :</label>
                <select id="recipe-category" name="recipe-category" required>
                    <option value="">-- Choisir une catégorie --</option>
                    <option value="salé">Salé</option>
                    <option value="sucré">Sucré</option>
                    <option value="salades">Salades</option>
                    <option value="gratins">Gratins</option>
                </select>
                <label for="recipe-ingredients">Ingrédients :</label>
                <textarea id="recipe-ingredients" name="recipe-ingredients" required></textarea>
                <label for="recipe-preparation">Préparation :</label>
                <textarea id="recipe-preparation" name="recipe-preparation" required></textarea>
                <label for="preparation-time">Temps de préparation (en minutes) :</label>
                <input type="number" id="preparation-time" name="preparation-time" required>
                <label for="cooking-time">Temps de cuisson (en minutes) :</label>
                <input type="number" id="cooking-time" name="cooking-time" required>
                <label for="servings">Nombre de portions :</label>
                <input type="number" id="servings" name="servings" required>
                <label for="recipe-image">Uploader une image :</label>
                <input type="file" id="recipe-image" name="recipe-image" accept="image/*" required>
                <label for="Nb">NB*</label>
                <input type="text" id="Nb" name="nb">
                <button type="submit" class="btn">Ajouter la recette</button>
            </form>
        <?php else: ?>
            <p style="color:#888;">Seul l'administrateur peut ajouter des recettes.</p>
        <?php endif; ?>
    </section>
    <footer>
        <p>&copy; 2025 SmartChef. All rights reserved.</p>
    </footer>
    <div id="cookie-banner"
        style="position:fixed;bottom:0;left:0;width:100%;background:#222;color:#fff;padding:1em;text-align:center;z-index:9999;display:none;">
        Ce site utilise des cookies pour améliorer votre expérience. <a href="politique_confidentialite.html"
            style="color:#FAB800;text-decoration:underline;">En savoir plus</a>.
        <button onclick="acceptCookies()" style="margin-left:1em;" class="btn">Accepter</button>
        <button onclick="refuseCookies()" style="margin-left:0.5em;background:#e74c3c;" class="btn">Refuser</button>
    </div>
    <script>
        /*document.querySelector('form').addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            try {
                                const response = await fetch('php/add.php', {
                                    method: 'POST',
                                    body: formData
                                });
                                const result = await response.json();
                                if (result.status === 'success') {
                                    Swal.fire({
                                        title: result.title,
                                        text: result.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        if (result.redirect) {
                                            window.location.href = result.redirect;
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: result.title,
                                        text: result.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            } catch (error) {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: 'Une erreur inattendue est survenue',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });*/
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
    <img src="assets/images/logo.jpg" alt="Logo Smart Chef" style="display:none;">
</body>

</html>