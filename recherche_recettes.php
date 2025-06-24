<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Recettes - SmartChef</title>
    <link rel="stylesheet" href="assets/css/style_f_r.css">
    <link rel="shortcut icon" href="assets/images/logo.jpg">
</head>

<body>
    <header>
        <?php session_start(); ?>
        <?php include 'nav.php'; ?>
    </header>
    <section id="recipes" style="max-width:800px;margin:2rem auto;">
        <h2>Recherche avancée de recettes</h2>
        <form action="php/recherche.php" method="POST" aria-label="Formulaire de recherche avancée">
            <label for="recipe_name">Nom de la recette :</label>
            <input type="text" id="recipe_name" name="recipe_name" placeholder="Nom de la recette">
            <label for="ingredients">Ingrédient(s) :</label>
            <input type="text" id="ingredients" name="ingredients" placeholder="Ex : poulet, tomate">
            <label for="category">Catégorie :</label>
            <select id="category" name="category">
                <option value="">-- Toutes --</option>
                <option value="salé">Salé</option>
                <option value="sucré">Sucré</option>
                <option value="salades">Salades</option>
                <option value="gratins">Gratins</option>
            </select>
            <label for="prep_time_max">Temps de préparation max (min) :</label>
            <input type="number" id="prep_time_max" name="prep_time_max" min="1" placeholder="Ex : 30">
            <label for="difficulty">Difficulté :</label>
            <select id="difficulty" name="difficulty">
                <option value="">-- Toutes --</option>
                <option value="facile">Facile</option>
                <option value="moyenne">Moyenne</option>
                <option value="difficile">Difficile</option>
            </select>
            <button type="submit" class="btn">Chercher</button>
        </form>
    </section>
    <footer>
        <p>&copy; 2025 SmartChef. All rights reserved.</p>
    </footer>
</body>

</html>