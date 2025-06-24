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
                text: 'Connexion réussie !'
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
                        echo "'Identifiants invalides.'";
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
        <?php
        include("nav.php");
        ?>
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
                    <a href="cree_compte.php">Pas de compte?</a>
                </label>
            </div>
            <input type="submit" value="Connexion" class="btn">
        </form>
    </section>
    <footer>
        <p>&copy; 2025 SmartChef. Tous droits réservés.</p>
    </footer>
    <script src="assets/js/afficher_pass.js"></script>
    <script src="assets/js/connexion.js"></script>
</body>

</html>