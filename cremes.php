<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_f_r.css">
    <title>fondant au chocolat</title>
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
        <h1>Créme dessert au chocolat</h1>
    </section>
    <section id="recipes">
        <div class="recipe-card">
            <div class="recipe-headr">
                <img src="img/cremes.jpg" alt="" style="border-radius: 2%; height: 700px;">
            </div>
            <div class="recipe-details">
                <h3>Details</h3>
                <p><strong>Temps de préparation :</strong> 5 minutes</p>
                <p><strong>Temps de cuisson :</strong> 10 minutes</p> 
                <p><strong>Nombre de portions :</strong> 4 petits pots</p>
                <p><strong>Temps de réfrigération :</strong>2h minimum</p>
            </div>
            <div class="recipe-content">
                <div class="ingredients">
                    <h3>Ingredients</h3>
                    <ul>
                        <li>500 ml de lait entier</li>
                        <li>100 g de chocolat noir (ou au lait, selon vos préférences)</li>
                        <li>2 jaunes d’œufs</li>
                        <li>40 g de sucre</li>
                        <li>20 g de maïzena (fécule de maïs)</li>
                        <li>1 cuillère à café d’extrait de vanille (facultatif)</li>
                    </ul>
                </div>
                <div class="préparation">
                    <h3>Préparation</h3>
                    <ol>
                        <li>
                            <strong>Préparez les ingrédients :</strong>
                            <ul>Cassez le chocolat en morceaux.</ul>
                            <ul>Dans un bol, mélangez les jaunes d’œufs avec le sucre et la maïzena jusqu’à obtenir un mélange homogène.</ul>
                        </li>
                        <li>
                            <strong>Faites chauffer le lait :</strong>
                            <ul>Dans une casserole, portez le lait à ébullition avec l’extrait de vanille (si utilisé).</ul>
                            <ul>Hors du feu, ajoutez le chocolat et mélangez jusqu’à ce qu’il soit complètement fondu.</ul>
                        </li>
                        <li>
                            <strong>Liez la crème :</strong>
                            <ul>Versez un peu de lait chocolaté chaud sur le mélange jaunes d’œufs/sucre/maïzena en fouettant vivement pour éviter les grumeaux.</ul>
                            <ul>Reversez le tout dans la casserole et faites cuire à feu doux en remuant constamment avec une spatule.</ul>
                        </li>
                        <li>
                            <strong>Cuisson :</strong>
                            <ul>Laissez épaissir pendant 2-3 minutes jusqu’à ce que la crème nappe la spatule (ne pas bouillir pour éviter de cuire les œufs).</ul>
                        </li>
                        <li>
                            <strong>Dressage et réfrigération :</strong>
                            <ul>Répartissez la crème dans des petits pots ou ramequins.</ul>
                            <ul>Couvrez d’un film alimentaire au contact pour éviter la formation d’une peau.</ul>
                            <ul>Placez au réfrigérateur pendant au moins 2h avant dégustation.</ul>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <footer>© 2025 SmartChef. All rights reserved.</footer>
</body>
</html>

