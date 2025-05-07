<?php

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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
</head>
<body>
    <nav class="main-navigation">
        <ul>
        
            <!-- Liens toujours visibles -->
            <li><a href="php/logout.php">de</a></li>
            <li><a href="index1.php">Accueil</a></li>
            <li><a href="about.html">À propos</a></li>
            <li><a href="about.html">Contact</a></li>

            <!-- Liens conditionnels -->
            <?php if(isset($_SESSION['id'])) : ?>
                <!-- Lien réservé aux utilisateurs connectés -->
                <li><a href="main.php">Ajouter des recettes</a></li>
                
                <?php if($_SESSION['role'] === 'admin') : ?>
                    <!-- Liens réservés aux admins -->
                    <li><a href="gere_users.php">Gérer les utilisateurs</a></li>
                    <li><a href="afficher_rec.php">Gérer les recettes</a></li>
                <?php endif; ?>
                
            <?php endif; ?>
        </ul>

        <div class="admin-nav">
            <?php if(isset($_SESSION['id'])) : ?>
                <!-- Affichage utilisateur connecté -->
                <span class="user-status">
                    <i class="fas fa-user"></i>
                    <?= htmlspecialchars($_SESSION['nom']) ?>
                    <small>(<?= htmlspecialchars($_SESSION['role']) ?>)</small>
                </span>
                
            <?php else : ?>
              
            <?php endif; ?>
        </div>
    </nav>
</body>
</html>