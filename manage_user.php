<?php
session_start();
include("php/cnx.php");

// Vérifier si l'utilisateur est un admin
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['message'] = "Accès non autorisé";
    $_SESSION['message_type'] = 'error';
    header("Location: ../connexion.php");
    exit();
}

// Fonction de validation
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Récupérer l'action
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

switch($action) {
    case 'add':
        // Ajout d'un nouvel utilisateur
        $username = validateInput($_POST['username']);
        $email = validateInput($_POST['email']);
        $password = $_POST['password'];
        $role = validateInput($_POST['role']);
        
        // Validation des données
        if(empty($username) || empty($email) || empty($password) || empty($role)) {
            $_SESSION['message'] = "Tous les champs sont obligatoires";
            $_SESSION['message_type'] = 'error';
            break;
        }
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "Format d'email invalide";
            $_SESSION['message_type'] = 'error';
            break;
        }
        
        // Vérifier si l'utilisateur existe déjà
        $stmt = $cnx->prepare("SELECT id FROM user WHERE nom = ? OR mail = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        
        if($stmt->num_rows > 0) {
            $_SESSION['message'] = "Nom d'utilisateur ou email déjà utilisé";
            $_SESSION['message_type'] = 'error';
            $stmt->close();
            break;
        }
        $stmt->close();
        
        // Hachage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        
        // Insertion dans la base de données
        $stmt = $cnx->prepare("INSERT INTO user (nom, mail, pass, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
        
        if($stmt->execute()) {
            $_SESSION['message'] = "Utilisateur ajouté avec succès";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Erreur lors de l'ajout de l'utilisateur";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
        break;
        
    case 'edit':
        // Modification d'un utilisateur existant
        $user_id = intval($_POST['user_id']);
        $username = validateInput($_POST['username']);
        $email = validateInput($_POST['email']);
        $password = $_POST['password'];
        $role = validateInput($_POST['role']);
        
        // Validation des données
        if(empty($username) || empty($email) || empty($role)) {
            $_SESSION['message'] = "Les champs obligatoires sont manquants";
            $_SESSION['message_type'] = 'error';
            break;
        }
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "Format d'email invalide";
            $_SESSION['message_type'] = 'error';
            break;
        }
        
        // Construction de la requête de mise à jour
        $query = "UPDATE user SET nom = ?, mail = ?, role = ?";
        $types = "sss";
        $params = array($username, $email, $role);
        
        // Si un nouveau mot de passe est fourni
        if(!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $query .= ", pass = ?";
            $types .= "s";
            $params[] = $hashed_password;
        }
        
        $query .= " WHERE id = ?";
        $types .= "i";
        $params[] = $user_id;
        
        // Préparation et exécution de la requête
        $stmt = $cnx->prepare($query);
        $stmt->bind_param($types, ...$params);
        
        if($stmt->execute()) {
            $_SESSION['message'] = "Utilisateur mis à jour avec succès";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Erreur lors de la mise à jour de l'utilisateur";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
        break;
        
    case 'delete':
        // Suppression d'un utilisateur
        $user_id = intval($_GET['id']);
        
        // Empêcher l'admin de se supprimer lui-même
        if($user_id == $_SESSION['id']) {
            $_SESSION['message'] = "Vous ne pouvez pas supprimer votre propre compte";
            $_SESSION['message_type'] = 'error';
            break;
        }
        
        $stmt = $cnx->prepare("DELETE FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        
        if($stmt->execute()) {
            $_SESSION['message'] = "Utilisateur supprimé avec succès";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression de l'utilisateur";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
        break;
        
    default:
        $_SESSION['message'] = "Action non reconnue";
        $_SESSION['message_type'] = 'error';
        break;
}

// Redirection vers la page admin
header("Location: gere_users.php");
exit();
?>