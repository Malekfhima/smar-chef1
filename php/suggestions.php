<?php
session_start();
include("cnx.php");
header('Content-Type: text/html; charset=utf-8');

function render_recette($recette)
{
    $html = '<div class="recette" style="display:inline-block;vertical-align:top;width:250px;margin:1em;background:#fff;border-radius:10px;box-shadow:0 2px 8px #eee;padding:1em;text-align:center;">';
    $html .= '<h3 style="font-size:1.1em;"><a href="../advanced.php?id=' . $recette['id'] . '">' . htmlspecialchars($recette['name']) . '</a></h3>';
    if (!empty($recette['image_path'])) {
        $html .= '<img src="../php/uploads/' . htmlspecialchars($recette['image_path']) . '" alt="Photo de la recette ' . htmlspecialchars($recette['name']) . '" style="max-width:100%;border-radius:8px;">';
    }
    $html .= '<p style="color:#888;font-size:0.95em;">Catégorie : ' . htmlspecialchars($recette['categorie']) . '</p>';
    $html .= '<a href="../advanced.php?id=' . $recette['id'] . '" class="btn" style="margin-top:0.5em;">Voir la recette</a>';
    $html .= '</div>';
    return $html;
}

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
if ($user_id) {
    // Suggestions basées sur les favoris (même catégorie)
    $fav = $cnx->prepare("SELECT DISTINCT r.categorie FROM recetts r INNER JOIN user_favoris f ON r.id = f.recette_id WHERE f.user_id = ?");
    $fav->bind_param("i", $user_id);
    $fav->execute();
    $fav_result = $fav->get_result();
    $categories = [];
    while ($row = $fav_result->fetch_assoc()) {
        $categories[] = $row['categorie'];
    }
    $fav->close();
    if ($categories) {
        $in = implode(',', array_fill(0, count($categories), '?'));
        $types = str_repeat('s', count($categories));
        $sql = "SELECT * FROM recetts WHERE categorie IN ($in) ORDER BY RAND() LIMIT 4";
        $stmt = $cnx->prepare($sql);
        $stmt->bind_param($types, ...$categories);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            while ($recette = $res->fetch_assoc()) {
                echo render_recette($recette);
            }
        } else {
            echo '<p>Aucune suggestion personnalisée trouvée.</p>';
        }
        $stmt->close();
    } else {
        echo '<p>Ajoutez des recettes à vos favoris pour obtenir des suggestions personnalisées !</p>';
    }
} else {
    // Suggestions populaires (par nombre d'avis)
    $sql = "SELECT r.*, COUNT(a.id) as nb_avis FROM recetts r LEFT JOIN recette_avis a ON r.id = a.recette_id GROUP BY r.id ORDER BY nb_avis DESC, RAND() LIMIT 4";
    $res = $cnx->query($sql);
    if ($res->num_rows > 0) {
        while ($recette = $res->fetch_assoc()) {
            echo render_recette($recette);
        }
    } else {
        echo '<p>Aucune suggestion disponible pour le moment.</p>';
    }
}
$cnx->close();