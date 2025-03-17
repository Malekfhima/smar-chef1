<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartChef - Find Recipes</title>
    <link rel="stylesheet" href="css/style_f_r.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#recipes">Recipes</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section id="home">
        <?php
            session_start();
            echo'<h1>Bienvenue et bon appétit  '. $_SESSION['nom'].' !</h1>';
        ?> 
        <p>Ready to find some amazing recipes? Start by entering your ingredients!</p>
    </section>

    <section id="recipes">
        <h2>Find Recipes</h2>
        <form action="#" method="POST">
            <label for="ingredients">Enter Ingredients:</label>
            <input type="text" id="ingredients" name="ingredients" placeholder="e.g., chicken, rice, tomato" required>
            <button type="submit" class="btn">Find Recipes</button>
        </form>
        <h3>Add Your Recipe</h3>
        <form action="php/add.php" method="POST" enctype="multipart/form-data">
            <label for="recipe-name">Recipe Name:</label>
            <input type="text" id="recipe-name" name="recipe-name" required>
            <label for="recipe-ingredients">Ingredients:</label>
            <textarea id="recipe-ingredients" name="recipe-ingredients" required></textarea>
            <label for="recipe-preparation">Préparation:</label>
            <textarea name="recipe-preparation" id="recipe-preparation"></textarea>
            <label for="recipe-image">Upload an Image:</label>
            <input type="file" id="recipe-image" name="recipe-image" accept="image/*" required>
            <button type="submit" class="btn">Add Recipe</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2025 SmartChef. All rights reserved.</p>
    </footer>
</body>
</html>
