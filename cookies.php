<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_f_r.css">
    <title>Cookies au pépites de chocolat</title>
    <link rel="shortcut icon" href="images/logo.jpg">
</head>
<body>
    <header>
    <?php
        session_start();
        include("nav.php");
        ?>
    </header>
    <section id="home">
        <h1>Cookies au pépites de chocolat</h1>
    </section>
    <section id="recipes">
        <div class="recipe-card">
            <div class="recipe-headr">
                <img src="img/cookies.jpg" alt="" style="border-radius: 2%;">
            </div>
            <div class="recipe-details">
                <h3>Details</h3>
                <p><strong>Temps de préparation :</strong> 15 minutes (+ 1h de repos au frigo)</p>
                <p><strong>Temps de cuisson :</strong> 10 à 12 minutes</p> 
                <p><strong>Nombre de portions :</strong> 12 à 15 cookies</p>
            </div>
            <div class="recipe-content">
                <div class="ingredients">
                    <h3>Ingredients</h3>
                    <ul>
                        <li>250 g de farine</li>
                        <li>1/2 cuillère à café de levure chimique</li>
                        <li>1/2 cuillère à café de bicarbonate de soude</li>
                        <li>1 pincée de sel</li>
                        <li>150 g de beurre mou (température ambiante)</li>
                        <li>100 g de sucre roux</li>
                        <li>100 g de sucre blanc</li>
                        <li>1 œuf</li>
                        <li>1 cuillère à café d’extrait de vanille</li>
                        <li>200 g de pépites de chocolat (noir, lait ou mixte)</li>
                    </ul>
                </div>
                <div class="préparation">
                    <h3>Préparation</h3>
                    <ol>
                        <li><strong>Mélangez les ingrédients secs :</strong> Dans un bol, tamisez la farine, la levure, le bicarbonate et le sel. Réservez.</li>
                        <li><strong>Créez la base :</strong> Dans un grand saladier, battez le beurre mou avec les sucres (blanc et roux) jusqu’à obtenir un mélange crémeux. Ajoutez l’œuf et la vanille, puis mélangez bien.</li>
                        <li><strong>Incorporez les ingrédients secs :</strong> Ajoutez progressivement le mélange farine/levure en mélangeant sans trop travailler la pâte. Terminez par les pépites de chocolat.</li>
                        <li><strong>Repos au frigo :</strong> Formez une boule avec la pâte, filmez-la et placez-la au réfrigérateur pendant <strong>1h</strong> (cela permet d’obtenir des cookies plus épais et moins étalés).</li>
                        <li><strong>Préchauffez le four </strong>à 180°C (thermostat 6). Recouvrez une plaque de cuisson de papier sulfurisé.</li>
                        <li><strong>Formez les cookies :</strong >Avec vos mains ou une cuillère à glace, façonnez des boules de pâte (environ 40 g chacune) et espacez-les bien sur la plaque (elles vont s’étaler).</li>
                        <li><strong>Cuisson :</strong> Enfournez pour <strong>10 à 12 minutes</strong> (les bords doivent être dorés mais le centre encore légèrement mou).</li>
                        <li><strong>Refroidissement :</strong> Laissez reposer 5 minutes sur la plaque avant de les transférer sur une grille.</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <footer>© 2025 SmartChef. All rights reserved.</footer>
</body>
</html>

