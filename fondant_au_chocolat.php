<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_f_r.css">
    <title>Fondant au chocolat</title>
    <link rel="shortcut icon" href="images/logo.jpg">
</head>
<body>
    <header>
    <?php
        session_start();
        include("nav.php");
        ?>
    </header>
    </header>
    <section id="home">
        <h1>Fondant au chocolat</h1>
    </section>
    <section id="recipes">
        <div class="recipe-card">
            <div class="recipe-headr">
                <img src="img/fondant.jpg" alt="" style="border-radius: 2%;">
            </div>
            <div class="recipe-details">
                <h3>Details</h3>
                <p><strong>Temps de préparation :</strong> 15 minutes</p>
                <p><strong>Temps de cuisson :</strong> 10 à 12 minutes</p> 
                <p><strong>Nombre de portions :</strong> 6 à 8 personnes</p>
            </div>
            <div class="recipe-content">
                <div class="ingredients">
                    <h3>Ingredients</h3>
                    <ul>
                        <li>200 g de chocolat noir (70% de cacao)</li>
                        <li>150 g de beurre doux (+ un peu pour le moule)</li>
                        <li>3 œufs</li>
                        <li>60 g de sucre en poudre</li>
                        <li>30 g de farine</li>
                        <li>1 pincée de sel</li>
                    </ul>
                </div>
                <div class="préparation">
                    <h3>Préparation</h3>
                    <ol>
                        <li><strong>Préchauffez le four</strong> à 180°C (thermostat 6). Beurrez un moule à manqué (20 cm de diamètre) et saupoudrez-le légèrement de farine.                        </li>
                        <li><strong>Faites fondre</strong> le chocolat et le beurre coupés en morceaux au bain-marie (ou au micro-ondes par courtes impulsions). Mélangez jusqu’à obtenir un mélange lisse.</li>
                        <li><strong>Dans un saladier</strong>, fouettez les œufs avec le sucre jusqu’à ce que le mélange blanchisse légèrement.</li>
                        <li><strong>Incorporez</strong> le chocolat fondu à la préparation aux œufs, puis ajoutez la farine et la pincée de sel. Mélangez bien jusqu’à obtenir une pâte homogène.</li>
                        <li><strong>Versez la pâte</strong> dans le moule préparé et enfournez pour <strong>10 à 12 minutes </strong> (surveillez la cuisson : le fondant doit être cuit sur les bords mais encore tremblant au centre pour un cœur coulant).</li>
                        <li><strong>Démoulez</strong> délicatement après 2-3 minutes de repos et servez tiède, accompagné d’une boule de glace vanille ou d’un coulis de fruits rouges.</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <footer>© 2025 SmartChef. All rights reserved.</footer>
</body>
</html>