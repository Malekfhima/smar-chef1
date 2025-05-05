<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes de cuisine</title>
    <script src="https://kit.fontawesome.com/0b6d538c32.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="shortcut icon" href="">
</head>
<body>
    <header>
        <?php include 'nav.php'; ?>
    </header>
    <?php
        session_start();
        echo '<h1>Bienvenue et bon appétit  ' . $_SESSION['nom'] . ' !</h1>';
        ?>
    <section class="section1">
        <div class="pages">
            <a href="recc.php?cat=sale"><img src="img/cote sale.jpg" alt="photo d'une pizza au poulet"></a>
            <h3>Côté salé</h3>
        </div>
        <div class="pages">
            <a href="recc.php?cat=sucre"><img src="img/cote sucre.jpg" alt="photo de crêpes sucrées"></a>
            <h3>Côté sucré</h3>
        </div>
        <div class="pages">
            <a href="recc.php?cat=salades"><img src="img/les salades.jpg" alt="salade de pomme de terres"></a>
            <h3>Les salades</h3>
        </div>
        <div class="pages">
            <a href="recc.php?cat=gratins"><img src="img/les gratins.jpg" alt="#"></a>
            <h3>Les gratins</h3>
        </div>
    </section>

    <section class="section2">
        <div class="position">
            <div class="bordure">
                <div><a href="fondant_au_chocolat.html"><img
                            src="img/fondant.jpg" alt="#"></a></div>
                <h3>Fondant au chocolat</h3>
            </div>
            <div class="bordure">
                <div><a href="cookies.html"><img src="img/cookies.jpg" alt="#"></a>
                </div>
                <h3>Cookies aux pépites de chocolat</h3>
            </div>
        </div>
        <div class="position">
            <div class="bordure">
                <a href="cremes.html"><img src="img/cremes.jpg"
                        alt="#"></a>
                <h3>Crèmes dessert au chocolat</h3>
            </div>

            <div class="bordure">
                <a href="brioche.html"><img src="img/brioche.jpg" alt="#"></a>
                <h3>Brioche</h3>
            </div>
        </div>
    </section>
    </section>
    <footer>
        <p>&copy; 2025 SmartChef. Tous droits réservés.</p>
    </footer>



</body>

</html>