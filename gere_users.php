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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Advent+Pro&family=Dancing+Script&display=swap');

/* Réinitialisation des styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    list-style-type: none;
    text-decoration: none;
}

/* Styles généraux */
body {
    font-family: 'Advent Pro', sans-serif;
    background-image: linear-gradient(to top, #FAB800 100%, #FAB800 100%);
    color: #333;
    line-height: 1.6;
}

/* Conteneur Admin */
.admin-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
    animation: fadeIn 1s ease-in-out;
}

/* En-tête Admin */
.admin-header {
    background-color: #0258A5;
    color: white;
    padding: 1.5rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
}

.admin-title {
    font-family: 'Dancing Script', cursive;
    font-size: 2.5rem;
    color: #fff;
}

.admin-nav {
    display: flex;
    align-items: center;
    gap: 20px;
}

.admin-nav a {
    color: #fff;
    font-size: 1.2rem;
    transition: color 0.3s ease;
}

.admin-nav a:hover {
    color: #ffcc00;
}

/* Gestion des utilisateurs */
.user-management {
    margin-left: 30px;
    width: 1470px;
    background-color: #ffffff;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
}

.section-title {
    font-family: 'Dancing Script', cursive;
    font-size: 2.5rem;
    color: #0258A5;
    margin-bottom: 1.5rem;
    text-align: center;
}

.add-btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background-color: #0258A5;
    color: white;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
    transition: transform 0.3s ease;
    border: none;
    cursor: pointer;
}

.add-btn:hover {
    transform: scale(1.05);
}

/* Tableau */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #0258A5;
    color: white;
    font-weight: bold;
}

tr:hover {
    background-color: #f9f9f9;
}

/* Boutons d'action */
.action-btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-right: 0.5rem;
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
    transform: scale(1.05);
    opacity: 0.9;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    animation: fadeIn 0.3s ease-in-out;
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 2rem;
    border-radius: 15px;
    width: 50%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    position: relative;
}

.close {
    position: absolute;
    top: 1rem;
    right: 1.5rem;
    font-size: 2rem;
    color: #aaa;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close:hover {
    color: #333;
}

/* Formulaire */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
    color: #333;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    font-family: 'Advent Pro', sans-serif;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #0258A5;
    outline: none;
    box-shadow: 0 0 0 2px rgba(2, 88, 165, 0.2);
}

.submit-btn {
    padding: 0.75rem 1.5rem;
    background-color: #0258A5;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.submit-btn:hover {
    transform: scale(1.02);
    background-color: #034a8a;
}

/* Messages d'alerte */
.alert {
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 8px;
    font-size: 1.1rem;
}

.alert-success {
    background-color: #dff0d8;
    color: #3c763d;
    border: 1px solid #d6e9c6;
}

.alert-error {
    background-color: #f2dede;
    color: #a94442;
    border: 1px solid #ebccd1;
}
/* Navigation principale */
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

/* Section admin */
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
/* Style du footer */
footer {
    background-color: #0258A5; /* Bleu en accord avec votre thème */
    color: #fff;
    text-align: center;
    padding: 2rem 1rem;
    margin-top: 3rem;
    font-family: 'Advent Pro', sans-serif;
    position: relative;
}

footer p {
    font-size: 1.1rem;
    margin: 0;
    padding: 0.5rem 0;
    letter-spacing: 0.5px;
}


/* Responsive */
@media (max-width: 768px) {
    .main-navigation {
        flex-direction: column;
        padding: 1rem;
    }
    
    .main-navigation ul {
        flex-direction: column;
        gap: 0.5rem;
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .main-navigation a {
        display: block;
        text-align: center;
        padding: 0.5rem;
    }
    
    .admin-nav {
        width: 100%;
        justify-content: center;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .modal-content {
        width: 90%;
    }
    
    table {
        display: block;
        overflow-x: auto;
    }
}
    </style>
</head>
<body>
    <?php include('php/cnx.php')?>
    <nav style="margin-bottom:20px;">
        <?php include('nav.php')?>
    </nav>

        
        <div class="user-management" style="margin-bottom: 30px;">
            <h2 class="section-title">Gestion des Utilisateurs</h2>
            
            <?php
            // Affichage des messages
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
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Modal Ajout/Modification -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Ajouter un utilisateur</h2>
            <form id="userForm" action="manage_user.php" method="POST">
                <input type="hidden" id="userId" name="user_id">
                <input type="hidden" id="actionType" name="action">
                
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
                    <input type="password" id="password" name="password">
                    <small id="passwordHelp">(Laisser vide pour ne pas changer)</small>
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
        // Gestion des modals
        function openModal(action, userId = null) {
            const modal = document.getElementById('userModal');
            const modalTitle = document.getElementById('modalTitle');
            const actionType = document.getElementById('actionType');
            const passwordHelp = document.getElementById('passwordHelp');
            
            if(action === 'add') {
                modalTitle.textContent = 'Ajouter un utilisateur';
                actionType.value = 'add';
                document.getElementById('userForm').reset();
                passwordHelp.style.display = 'block';
            } else if(action === 'edit') {
                modalTitle.textContent = 'Modifier l\'utilisateur';
                actionType.value = 'edit';
                passwordHelp.style.display = 'block';
                
                // Récupérer les données de l'utilisateur via AJAX
                fetch('get_user.php?id=' + userId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('userId').value = data.id;
                        document.getElementById('username').value = data.nom;
                        document.getElementById('email').value = data.mail;
                        document.getElementById('role').value = data.role;
                    });
            }
            
            modal.style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('userModal').style.display = 'none';
        }
        
        function confirmDelete(userId) {
            if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                window.location.href = 'manage_user.php?action=delete&id=' + userId;
            }
        }
        
        // Fermer le modal en cliquant en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('userModal');
            if(event.target == modal) {
                closeModal();
            }
        }
    </script>
    <footer><?php include('footer.php');?></footer>
</body>

</html>