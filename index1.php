<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes de cuisine</title>
    <link rel="stylesheet" href="css/style1.css">
    <script src="https://kit.fontawesome.com/0b6d538c32.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="">
</head>

<body>

    <header>
        <?php
        session_start();
        echo '<h1>Bienvenue et bon appétit  ' . $_SESSION['nom'] . ' !</h1>';
        ?>
        <a href="main.php">incerte</a>
    </header>

    <section class="section1">
        <div class="pages">
            <a href="#"><img src="./images/salé/pizza poulet.jpeg" alt="photo d'une pizza au poulet"></a>
            <h3>Côté salé</h3>
        </div>
        <div class="pages">
            <a href="#"><img src="./images/sucré/crepes.jpg" alt="photo de crêpes sucrées"></a>
            <h3>Côté sucré</h3>
        </div>
        <div class="pages">
            <a href="#"><img src="./images/salades/salade de pommes de terre.jpg" alt="salade de pomme de terres"></a>
            <h3>Les salades</h3>
        </div>
        <div class="pages">
            <a href="#"><img src="./images/gratins/gratinsjpg.jpg" alt="#"></a>
            <h3>Les gratins</h3>
        </div>
    </section>

    <section class="section2">
        <div class="position">
            <div class="bordure">
                <div><a href="./pages/recettesSucrées/gateaux/fondant.html"><img
                            src="./images/sucré/gateau-au-chocolat.jpeg" alt="#"></a></div>
                <h3>Fondant au chocolat</h3>
            </div>
            <div class="bordure">
                <div><a href="./pages/recettesSucrées/cookies.html"><img src="./images/sucré/cookies.jpg" alt="#"></a>
                </div>
                <h3>Cookies aux pépites de chocolat</h3>
            </div>
        </div>
        <div class="position">
            <div class="bordure">
                <a href="./pages/recettesSucrées/cremes/cremeDessert.html"><img src="./images/sucré/creme-chocolat.jpg"
                        alt="#"></a>
                <h3>Crèmes dessert au chocolat</h3>
            </div>

            <div class="bordure">
                <a href="./pages/recettesSucrées/brioche.html"><img src="./images/sucré/brioche.jpg" alt="#"></a>
                <h3>Brioche</h3>
            </div>
        </div>
    </section>

    <h2>SOS en cuisine</h2>
    <p>Suivez tous mes conseils et astuces pour devenir un pro des fourneaux</p>

    <section class="section3">

        <div class="center bordure2">
            <a href="./astuces/lien-betteraves/les-betteraves-rouges.html"><img
                    src="./images/astuces/betteraves-rouges.jpeg" alt="cuire les betteraves rouges"></a>
            <h3>Comment cuire les betteraves rouges?</h3>
        </div>
        <div class="center bordure2">
            <a href="./astuces/déglacage/déglacage.html"><img src="./images/astuces/déglacer.webp"
                    alt="déglacer en cuisine"></a>
            <h3>Déglacer en cuisine, comment faire?</h3>
        </div>
        <div class="center bordure2">
            <a href="#"><img src="./images/astuces/oignons-caramelises.webp" alt="caraméliser les oignons"></a>
            <h3>Comment caraméliser les oignons?</h3>
        </div>

    </section>




</body>

</html>