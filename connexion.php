<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartChef - Inscription</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#about">À propos</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    <section id="home">
        <h1>Bienvenue chez SmartChef</h1>
        <p>Trouvez de délicieuses recettes à partir des ingrédients que vous avez ! Inscrivez-vous ci-dessous.</p>
    </section>
    <section id="signup">
        <h2>Connexion</h2>
        <form action="php/connexion.php" method="post" onsubmit="return verif()">
            <input type="text" id="username" name="username" required placeholder="Nom d'utilisateur">
            <input type="password" id="password" name="password" required placeholder="Mot de passe">
            <div class="forget">
                <label>
                    <input type="checkbox" id="show-password" onclick="affiche_pass()">Afficher Mot de passe
                </label>
                <label>
                    <a href="index.php">Pas de compte?</a>
                </label>
            </div>
            <input type="submit" value="Connexion" class="btn">
        </form>
    </section>
    <footer>
        <p>&copy; 2025 SmartChef. Tous droits réservés.</p>
    </footer>
    <script src="js/afficher_pass.js"></script>
    <script src="js/connexion.js"></script>
</body>

</html>