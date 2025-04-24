<?php
// Connexion à la base de données
include("php/cnx.php");

// Récupération des catégories depuis la base de données
try {
    $query = $pdo->query("SELECT id, nom, image_url, description FROM categories WHERE actif = 1 ORDER BY ordre_affichage");
    $categories = $query->fetchAll();
} catch (PDOException $e) {
    die('Erreur lors de la récupération des catégories : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories de Recettes</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        h1 {
            text-align: center;
            margin: 40px 0;
            color: #2c3e50;
            font-size: 2.5em;
            font-weight: 300;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            max-width: 1200px;
            padding: 20px;
            margin-bottom: 40px;
        }

        .category-card {
            width: 280px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 25px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }

        .image-circle {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 20px;
            border: 5px solid #e74c3c;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .image-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .category-card:hover .image-circle img {
            transform: scale(1.1);
        }

        .category-title {
            text-align: center;
            color: #2c3e50;
            margin: 0 0 10px 0;
            font-size: 1.5em;
            font-weight: 500;
        }

        .category-desc {
            text-align: center;
            color: #7f8c8d;
            font-size: 0.95em;
            line-height: 1.4;
        }

        .no-categories {
            text-align: center;
            color: #7f8c8d;
            font-size: 1.2em;
            padding: 40px;
        }

        @media (max-width: 768px) {
            .container {
                gap: 20px;
                padding: 10px;
            }
            
            .category-card {
                width: 100%;
                max-width: 350px;
            }
        }
    </style>
</head>
<body>
    <h1>Découvrez nos Catégories</h1>
    
    <div class="container">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $categorie): ?>
                <a href="recettes.php?categorie_id=<?= htmlspecialchars($categorie['id']) ?>" class="category-card">
                    <div class="image-circle">
                        <img src="<?= htmlspecialchars($categorie['image_url']) ?>" alt="<?= htmlspecialchars($categorie['nom']) ?>">
                    </div>
                    <h3 class="category-title"><?= htmlspecialchars($categorie['nom']) ?></h3>
                    <p class="category-desc"><?= htmlspecialchars($categorie['description']) ?></p>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-categories">
                <p>Aucune catégorie disponible pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php
    // Fermeture de la connexion
    $pdo = null;
    ?>
</body>
</html>