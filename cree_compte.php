<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartChef - Inscription</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="images/logo.jpg">
</head>
<body>
    <header>
        <?php include 'nav.php'; ?>
    </header>
    <section id="home">
        <h1>Bienvenue chez SmartChef</h1>
        <p>Trouvez de délicieuses recettes à partir des ingrédients que vous avez ! Inscrivez-vous ci-dessous.</p>
    </section>
    <section id="signup">
        <h2>Créer un compte</h2>
        <form action="php/main.php" method="post" onsubmit="return verif()">
            <input type="text" id="username" name="username" required placeholder="Nom d'utilisateur">
            <input type="email" id="email" name="email" required placeholder="E-mail">
            <input type="password" id="password" name="password" required placeholder="Mot de passe">
            <input type="password" id="confirm-password" name="confirm-password" required
                placeholder="Confirmer le mot de passe">
            <div class="forget">
                <label>
                    <input type="checkbox" id="show-password" onclick="affiche_pass()">Afficher Mot de passe
                </label>
                <label>
                    <a href="connexion.php">J'ai un compte?</a>
                </label>
            </div>
            <input type="submit" value="S'inscrire" class="btn">
        </form>
    </section>
    <footer>
        <p>&copy; 2025 SmartChef. Tous droits réservés.</p>
    </footer>
    <script src="js/afficher_pass.js"></script>
    <script src="js/cree_compte.js"></script>
</body>

</html>