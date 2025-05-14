<?php
session_start();
include("php/cnx.php");

// Vérifier si l'utilisateur est admin
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: connexion.php");
    exit();
}

// Traitement de la suppression
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM recetts WHERE id = ?";
    $stmt = mysqli_prepare($cnx, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Recette supprimée avec succès";
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression: " . mysqli_error($cnx);
        $_SESSION['message_type'] = 'error';
    }
    
    header("Location: afficher_rec.php");
    exit();
}

// Récupérer toutes les recettes
$query = "SELECT * FROM recetts ORDER BY id DESC";
$result = mysqli_query($cnx, $query);

// Vérifier si la requête a réussi
if(!$result) {
    die("Erreur de requête: " . mysqli_error($cnx));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des recettes</title>
    <link rel="stylesheet" href="css/style1.css">
    <link rel="shortcut icon" href="images/logo.jpg">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .recipe-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .recipe-table th, .recipe-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .recipe-table th {
            background-color: #005C9C;
            color: white;
        }
        
        .recipe-table tr:hover {
            background-color: #f9f9f9;
        }
        
        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            margin-right: 0.5rem;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
        }
        
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        
        .action-btn:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
        }
        
        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        
        .alert-error {
            background-color: #f2dede;
            color: #a94442;
        }
        
        .no-recipes {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header>
        <?php include 'nav.php'; ?>
    </header>
    
    <div class="admin-container">
        <h1>Gestion des recettes</h1>
        
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?>">
                <?= $_SESSION['message'] ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>
        
        <?php if(mysqli_num_rows($result) > 0): ?>
            <table class="recipe-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($recipe = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($recipe['id']) ?></td>
                        <td>
                            <?php if(!empty($recipe['image_path'])): ?>
                                <img src="php/uploads/<?= htmlspecialchars(basename($recipe['image_path'])) ?>" 
                                     alt="<?= htmlspecialchars($recipe['name']) ?>" 
                                     style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <span>Aucune image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($recipe['name']) ?></td>
                        <td><?= htmlspecialchars($recipe['cat']) ?></td>
                        <td>
                            
                            <a href="afficher_rec.php?action=delete&id=<?= $recipe['id'] ?>" 
                               class="action-btn delete-btn"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?')">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-recipes">
                <p>Aucune recette trouvée dans la base de données.</p>
                <a href="main.php" class="action-btn edit-btn">Ajouter une recette</a>
            </div>
        <?php endif; ?>
    </div>
    
    <footer>
        <p>&copy; 2025 SmartChef. Tous droits réservés.</p>
    </footer>
</body>
</html>