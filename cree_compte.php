<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartChef - Inscription</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="assets/images/logo.jpg">
</head>

<body>
    <?php if (isset($_GET['success'])): ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: 'Compte créé avec succès ! Vous pouvez vous connecter.'
    });
    </script>
    <?php elseif (isset($_GET['error'])): ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: <?php
                switch ($_GET['error']) {
                    case 'exists':
                        echo "'Ce nom d\'utilisateur ou cet email existe déjà.'";
                        break;
                    case 'mdp':
                        echo "'Les mots de passe ne correspondent pas.'";
                        break;
                    case 'empty':
                        echo "'Veuillez remplir tous les champs.'";
                        break;
                    default:
                        echo "'Une erreur est survenue.'";
                }
                ?>
    });
    </script>
    <?php endif; ?>
    <header>
        <?php session_start();
        include 'nav.php'; ?>
    </header>
    <section id="home">
        <h1>Bienvenue chez SmartChef</h1>
        <p>Trouvez de délicieuses recettes à partir des ingrédients que vous avez ! Inscrivez-vous ci-dessous.</p>
    </section>
    <section id="signup">
        <h2>Créer un compte</h2>
        <form action="php/inscription.php" method="post" onsubmit="return verif()">
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
    <script src="assets/js/afficher_pass.js"></script>
    <script src="assets/js/cree_compte.js"></script>
</body>

</html>