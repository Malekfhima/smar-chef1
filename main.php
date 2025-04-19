<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartChef - Find Recipes</title>
    <link rel="stylesheet" href="css/style_f_r.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <?php include 'nav.php'; ?>
    </header>
    <section id="home">
        <?php
        session_start();
        echo '<h1>Bienvenue et bon appétit  ' . $_SESSION['nom'] . ' !</h1>';
        ?>
        <p>Ready to find some amazing recipes? Start by entering your ingredients!</p>
    </section>
    <section id="recipes">
        <h2>Rechercher des recettes</h2>
        <form action="php/afficher.php" method="POST">
    <label for="ingredients">Entrez un ingrédient :</label>
    <input type="text" id="ingredients" name="nom" placeholder="Ingrédient" required>
    <button type="submit" class="btn">Chercher</button>
</form>
        <h3>Add Your Recipe</h3>
        <form action="php/add.php" method="POST" enctype="multipart/form-data">
    <label for="recipe-name">Nom de la recette :</label>
    <input type="text" id="recipe-name" name="recipe-name" required>
    
    <label for="recipe-category">Catégorie :</label>
    <select id="recipe-category" name="recipe-category" required>
        <option value="">-- Choisir une catégorie --</option>
        <option value="Salé">Salé</option>
        <option value="Sucré">Sucré</option>
        <option value="Les salades">Salades</option>
        <option value="Les gratins">Gratins</option>
    </select>
    
    <label for="recipe-ingredients">Ingrédients :</label>
    <textarea id="recipe-ingredients" name="recipe-ingredients" required></textarea>
    
    <label for="recipe-preparation">Préparation :</label>
    <textarea id="recipe-preparation" name="recipe-preparation" required></textarea>
    
    <label for="preparation-time">Temps de préparation (en minutes) :</label>
    <input type="number" id="preparation-time" name="preparation-time" required>
    
    <label for="cooking-time">Temps de cuisson (en minutes) :</label>
    <input type="number" id="cooking-time" name="cooking-time" required>
    
    <label for="servings">Nombre de portions :</label>
    <input type="number" id="servings" name="servings" required>
    
    <label for="recipe-image">Uploader une image :</label>
    <input type="file" id="recipe-image" name="recipe-image" accept="image/*" required>
    
    <button type="submit" class="btn">Ajouter la recette</button>
</form>
    </section>

    <footer>
        <p>&copy; 2025 SmartChef. All rights reserved.</p>
    </footer>
    <script>
/*document.querySelector('form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('php/add.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            Swal.fire({
                title: result.title,
                text: result.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                if (result.redirect) {
                    window.location.href = result.redirect;
                }
            });
        } else {
            Swal.fire({
                title: result.title,
                text: result.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'Erreur',
            text: 'Une erreur inattendue est survenue',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
});*/
</script>
</body>

</html>