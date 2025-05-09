<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartChef - Find Recipes</title>
    <link rel="stylesheet" href="css/style_f_r.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="images/logo.jpg">
</head>
<style>
    .user-info {
        margin-right: 15px;
        color: #fff;
        font-weight: bold;
    }
    .main-navigation {
    background-color: #0258A5;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.main-navigation ul {
    display: flex;
    gap: 1.5rem;
    margin: 0;
    padding: 0;
}
.main-navigation li {
    list-style: none;
}
.main-navigation a {
    color: #fff;
    font-family: 'Advent Pro', sans-serif;
    font-size: 1.2rem;
    font-weight: 500;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
}
.main-navigation a:hover {
    color: #ffcc00;
    background-color: rgba(255, 255, 255, 0.1);
}
.main-navigation a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background-color: #ffcc00;
    transition: all 0.3s ease;
    transform: translateX(-50%);
}
.main-navigation a:hover::after {
    width: 70%;
}
.admin-nav {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}
.admin-nav span {
    color: #fff;
    font-family: 'Advent Pro', sans-serif;
    font-size: 1.1rem;
    background-color: rgba(255, 255, 255, 0.1);
    padding: 0.5rem 1rem;
    border-radius: 8px;
}
</style>
<body>
    <header>
    <?php session_start();?>
        <?php include 'nav.php'; ?>
        <div class="nav-links">
        </div>
    </header>
    <section id="home">
        <?php
        echo '<h1>Bienvenue et bon appétit  ' . $_SESSION['nom'] . ' !</h1>';
        ?>
        <p>Prêt à découvrir de délicieuses recettes ? Commencez par saisir vos ingrédients !</p>
    </section>
    <section id="recipes">
        <h2>Rechercher Des Recettes</h2>
        <form action="php/afficher.php" method="POST">
    <label for="ingredients">Entrez un ingrédient :</label>
    <input type="text" id="ingredients" name="nom" placeholder="Ingrédient" required>
    <button type="submit" class="btn">Chercher</button>
</form>
        <h3>Ajouter Votre Recette</h3>
        <form action="php/add.php" method="POST" enctype="multipart/form-data">
    <label for="recipe-name">Nom de la recette :</label>
    <input type="text" id="recipe-name" name="recipe-name" required>
    <label for="recipe-category">Catégorie :</label>
    <select id="recipe-category" name="recipe-category" required>
        <option value="">-- Choisir une catégorie --</option>
        <option value="salé">Salé</option>
        <option value="sucré">Sucré</option>
        <option value="salades">Salades</option>
        <option value="gratins">Gratins</option>
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
    <label for="Nb">NB*</label>
    <input type="text" id="Nb" name="nb">
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