<?php
include "php/cnx.php";
session_start();
if(!isset($_GET['cat'])) {
    header("Location: index1.php");
    exit();
}
$stmt = mysqli_prepare($cnx, "SELECT id, name, image_path FROM recetts WHERE cat = ?");
mysqli_stmt_bind_param($stmt, "s", $_GET['cat']);
mysqli_stmt_execute($stmt);
$result_item = mysqli_stmt_get_result($stmt);
if(!$result_item) {
    die("Erreur de requête : " . mysqli_error($cnx));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style1.css">
    <title>Recettes - <?= htmlspecialchars($_GET['cat']) ?></title>
    <link rel="shortcut icon" href="images/logo.jpg">
</head>
<body>
    <header><?php include "nav.php"; ?></header>
    <section class="section2">
        <?php if(mysqli_num_rows($result_item) == 0) : ?>
            <script>
                alert("Catégorie vide !");
                window.location.href = "index1.php";
            </script>
        <?php else : ?>
            <?php while($row = mysqli_fetch_assoc($result_item)) : ?>
                <?php
                // Chemins des images
                $image_file = 'php/uploads/' . basename($row['image_path']);
                $absolute_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $image_file;
                ?>
                <div class="position">
                    <div class="bordure">
                        <a href="advanced.php?id=<?= $row['id'] ?>">
                            <img src="<?= $image_file ?>" 
                                 alt="<?= htmlspecialchars($row['name']) ?>"
                                 class="recette-image">
                        </a>
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </section>
    <footer><?php include "footer.php"; ?></footer>
</body>
</html>