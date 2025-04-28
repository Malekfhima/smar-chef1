<?php
// recettes.php
session_start();
include("php/cnx.php");

// Debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Correction ligne 10 : Vérification et récupération sécurisée
if (!isset($_SESSION['resultats_recherche'])) { // Clé de session fixe
    die("Aucune donnée disponible. Retour à <a href='index1.php'>l'accueil</a>.");
}

$donnees = $_SESSION['resultats_recherche'];
unset($_SESSION['resultats_recherche']);

// Debug
echo "<pre>Données session: ";
print_r($donnees);
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        .recette {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px;
        }
        img {
            max-width: 200px;
        }
    </style>
</head>
<body>

    <!-- Correction ligne 35 : Structure cohérente -->
    <h1>Catégorie: <?= htmlspecialchars($donnees['categorie'] ?? 'Inconnue') ?></h1>
    
    <?php if (empty($donnees['recettes'])): ?>
        <p>Aucune recette trouvée</p>
    <?php else: ?>
        <?php foreach ($donnees['recettes'] as $recette): ?>
            <div class="recette">
                <h2><?= htmlspecialchars($recette['name'] ?? 'Nom inconnu') ?></h2>
                <?php if (!empty($recette['image_path'])): ?>
                    <img src="<?= htmlspecialchars($recette['image_path']) ?>" 
                         alt="<?= htmlspecialchars($recette['name'] ?? '') ?>">
                <?php endif; ?>
                <p>Temps: <?= $recette['temps_preparation'] ?? '?' ?> min</p>
                <h3>Ingrédients:</h3>
                <ul>
                    <?php foreach (explode("\n", $recette['ingredients'] ?? '') as $ing): ?>
                        <?php if (!empty(trim($ing))): ?>
                            <li><?= htmlspecialchars(trim($ing)) ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>