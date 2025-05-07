
<nav class="main-navigation">
    <ul>
        <li><a href="index1.php">Accueil</a></li>
        <li><a href="about.html">À propos</a></li>
        <li><a href="about.html">Contact</a></li>
        <li><a href="main.php">Ajouter des recettes</a></li>
        
        <li><a href="gere_users.php">Gere Les Utilisateurs</a></li>
        <li><a href="afficher_rec.php">Modifer les recettes</a></li>
    </ul>
    <div class="admin-nav">
                <span>Connecté en tant que <?= htmlspecialchars($_SESSION['nom']) ?> <?php htmlspecialchars($_SESSION['role'])?></span>
            </div>
</nav>