<?php
session_start();
// Vérification du rôle admin
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: connexion.php");
    exit();
}

include("php/cnx.php");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion Utilisateurs</title>
    <link rel="stylesheet" href="assets/css/gere.css">
    <link rel="shortcut icon" href="assets/images/logo.jpg">
</head>

<body>
    <?php include('php/cnx.php')?>
    <nav style="margin-bottom:20px;">
        <?php include('nav.php')?>
    </nav>
    <div class="user-management" style="margin-bottom: 30px;">
        <h2 class="section-title">Gestion des Utilisateurs</h2>
        <?php
        if(isset($_SESSION['message'])) {
            echo '<div class="alert alert-'.$_SESSION['message_type'].'">'.$_SESSION['message'].'</div>';
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>
        <a href="#" class="add-btn" onclick="openModal('add')">+ Ajouter un utilisateur</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT id, nom, mail, role FROM user ORDER BY id DESC";
                $result = mysqli_query($cnx, $query);
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>".htmlspecialchars($row['id'])."</td>
                            <td>".htmlspecialchars($row['nom'])."</td>
                            <td>".htmlspecialchars($row['mail'])."</td>
                            <td>".htmlspecialchars($row['role'])."</td>
                            <td>
                                <button class='action-btn edit-btn' onclick='openModal(\"edit\", ".$row['id'].")'>Modifier</button>
                                <button class='action-btn delete-btn' onclick='confirmDelete(".$row['id'].")'>Supprimer</button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Aucun utilisateur trouvé</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Ajouter un utilisateur</h2>
            <form id="userForm" action="manage_user.php" method="POST">
                <input type="hidden" id="userId" name="user_id">
                <input type="hidden" id="actionType" name="action" value="add">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" minlength="6">
                    <small id="passwordHelp">(Minimum 6 caractères)</small>
                </div>
                <div class="form-group">
                    <label for="role">Rôle</label>
                    <select id="role" name="role" required>
                        <option value="utilisateur">Utilisateur</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Enregistrer</button>
            </form>
        </div>
    </div>
    <script>
    function openModal(action, userId = null) {
        const modal = document.getElementById('userModal');
        const modalTitle = document.getElementById('modalTitle');
        const actionType = document.getElementById('actionType');
        const passwordField = document.getElementById('password');
        const passwordHelp = document.getElementById('passwordHelp');
        if (action === 'add') {
            modalTitle.textContent = 'Ajouter un utilisateur';
            actionType.value = 'add';
            document.getElementById('userForm').reset();
            passwordField.required = true;
            passwordHelp.textContent = '(Minimum 6 caractères)';
        } else if (action === 'edit') {
            modalTitle.textContent = 'Modifier l\'utilisateur';
            actionType.value = 'edit';
            passwordField.required = false;
            passwordHelp.textContent = '(Laisser vide pour ne pas changer)';
            fetch('php/get_user.php?id=' + userId)
                .then(response => {
                    if (!response.ok) throw new Error('Erreur réseau');
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    document.getElementById('userId').value = data.id;
                    document.getElementById('username').value = data.nom;
                    document.getElementById('email').value = data.mail;
                    document.getElementById('role').value = data.role;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors du chargement des données utilisateur');
                });
        }
        modal.style.display = 'block';
    }

    function closeModal() {
        document.getElementById('userModal').style.display = 'none';
    }

    function confirmDelete(userId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
            window.location.href = 'manage_user.php?action=delete&id=' + userId;
        }
    }
    window.onclick = function(event) {
        const modal = document.getElementById('userModal');
        if (event.target == modal) {
            closeModal();
        }
    }
    </script>
    <footer><?php include('footer.php');?></footer>
</body>

</html>