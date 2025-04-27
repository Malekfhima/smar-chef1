<?php
/**
 * Page d'affichage des catégories de recettes
 * @package SmartChef
 */

// Configuration des erreurs
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/errors.log');

// Inclusion sécurisée du fichier de connexion
require_once __DIR__ . '/php/cnx.php';

// Vérification de la connexion PDO
if (!($cnx instanceof PDO)) {
    error_log('Erreur: Connexion DB invalide dans categories.php');
    die('<div class="error">Erreur système. Veuillez réessayer plus tard.</div>');
}

try {
    // Préparation et exécution de la requête
    $stmt = $cnx->prepare("
        SELECT id, nom, image_url, description 
        FROM categories 
        WHERE actif = 1 
        ORDER BY ordre_affichage
    ");
    
    if (!$stmt->execute()) {
        throw new PDOException("Erreur d'exécution de requête");
    }
    
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;

} catch (PDOException $e) {
    error_log('Erreur DB dans categories.php: ' . $e->getMessage());
    $error_message = 'Une erreur est survenue lors du chargement des catégories.';
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez nos catégories de recettes culinaires">
    <title>Catégories de Recettes | SmartChef</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <style>
        :root {
            --primary: #e74c3c;
            --secondary: #2c3e50;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #7f8c8d;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }
        
        .header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .page-title {
            text-align: center;
            margin: 2rem 0 3rem;
            color: var(--secondary);
            position: relative;
            font-weight: 300;
            font-size: 2.5rem;
        }
        
        .page-title::after {
            content: "";
            display: block;
            width: 80px;
            height: 4px;
            background-color: var(--primary);
            margin: 1rem auto;
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }
        
        .category-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
        }
        
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.12);
        }
        
        .category-img {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 1.5rem;
            border: 5px solid var(--primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .category-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .category-card:hover .category-img img {
            transform: scale(1.1);
        }
        
        .category-name {
            font-size: 1.5rem;
            margin: 0 0 0.5rem;
            color: var(--secondary);
            text-align: center;
            font-weight: 500;
        }
        
        .category-desc {
            color: var(--gray);
            text-align: center;
            font-size: 0.95rem;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 0.25rem;
            margin: 2rem auto;
            max-width: 600px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .categories-grid {
                grid-template-columns: 1fr;
            }
            
            .page-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1><i class="fas fa-utensils"></i> SmartChef</h1>
        </div>
    </header>
    
    <main class="container">
        <h2 class="page-title">Découvrez nos Catégories</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error_message) ?>
            </div>
        <?php elseif (empty($categories)): ?>
            <div class="error-message">
                <i class="fas fa-info-circle"></i> Aucune catégorie disponible pour le moment.
            </div>
        <?php else: ?>
            <div class="categories-grid">
                <?php foreach ($categories as $categorie): ?>
                    <a href="recettes.php?categorie_id=<?= htmlspecialchars($categorie['id']) ?>" class="category-card">
                        <div class="category-img">
                            <img src="<?= htmlspecialchars($categorie['image_url'] ?? '/images/default-category.jpg') ?>" 
                                 alt="<?= htmlspecialchars($categorie['nom']) ?>"
                                 loading="lazy">
                        </div>
                        <h3 class="category-name"><?= htmlspecialchars($categorie['nom']) ?></h3>
                        <p class="category-desc"><?= htmlspecialchars($categorie['description']) ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> SmartChef. Tous droits réservés.</p>
        </div>
    </footer>
    
    <?php
    // Fermeture de la connexion
    $cnx = null;
    ?>
</body>
</html>