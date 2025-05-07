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
    <section id="home">
        <h1>Brioche</h1>
    </section>
    <section id="recipes">
        <div class="recipe-card">
            <div class="recipe-headr">
                <img src="img/brioche.jpg" alt="" style="border-radius: 2%; height: 500px;">
            </div>
            <div class="recipe-details">
                <h3>Details</h3>
                <p><strong>Temps de préparation :</strong> 20 minutes (+ 2h30 de levée)</p>
                <p><strong>Temps de cuisson :</strong> 25 à 30 minutes</p> 
                <p><strong>Nombre de portions :</strong> 1 grande brioche (environ 8 parts)</p>
            </div>
            <div class="recipe-content">
                <div class="ingredients">
                    <h3>Ingredients</h3>
                    <ul>
                        <li>500 g de farine T45 (ou farine à brioche)</li>
                        <li>10 g de sel</li>
                        <li>50 g de sucre</li>
                        <li>1 sachet de levure boulangère (5-7 g) ou 20 g de levure fraîche</li>
                        <li>5 œufs (dont 1 pour la dorure)</li>
                        <li>250 g de beurre mou (en dés, température ambiante)</li>
                        <li>50 ml de lait tiède</li>
                        <li>1 c. à soupe d’eau (pour la dorure)</li>
                        <li>Sucre perlé (facultatif, pour la décoration)</li>
                    </ul>
                </div>
                <div class="préparation">
                    <h3>Préparation</h3>
                    <ol>
                        <li>
                            <strong>1. Pétrissage :</strong>
                            <ul>Dans un bol, diluez la levure dans 2 c. à soupe d’eau tiède (si elle est fraîche).</ul>
                            <ul>Dans un robot pétrin (ou à la main), mélangez la farine, le sucre et le sel.</ul>
                            <ul>Ajoutez les 5 œufs un à un, puis la levure.</ul>
                            <ul>Pétrissez 10 min jusqu’à obtenir une pâte homogène et élastique.</ul>
                            <ul>Incorporez le beurre mou coupé en morceaux petit à petit. Pétrissez encore 10 min jusqu’à ce que la pâte se décolle des parois.</ul>
                        </li>
                        <li>
                            <strong>2. Pointage (1re levée) :</strong>
                            <ul>Couvrez la pâte d’un torchon et laissez lever 1h30 à 2h dans un endroit tiède (elle doit doubler de volume).</ul>
                        </li>
                        <li>
                            <strong>3. Façonnage :</strong>
                            <ul>Dégazez la pâte en la pressant légèrement.</ul>
                            <ul>Divisez-la en parts égales (en boules ou pour un moule à brioche).</ul>
                            <ul>Placez dans un moule beurré et laissez lever à nouveau 1h (recouvert d’un torchon).</ul>
                        </li>
                        <li>
                            <strong>4. Cuisson :</strong>
                            <ul>Préchauffez le four à 180°C (th. 6).</ul>
                            <ul>Dorez la brioche avec un mélange d’œuf battu + lait + sucre.</ul>
                            <ul>Enfournez pour 25 à 30 min (jusqu’à ce qu’elle soit bien dorée).</ul>
                        </li>
                        <li>
                            <strong>5. Démoulage :</strong>
                            <ul>Sortez la brioche du four et laissez tiédir avant de démouler.</ul>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <footer>© 2025 SmartChef. All rights reserved.</footer>
</body>
</html>

