<?php
session_start();
include("php/cnx.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['message'] = "Accès non autorisé";
    $_SESSION['message_type'] = "error";
    header("Location: connexion.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        if ($id == $_SESSION['id']) {
            $_SESSION['message'] = "Vous ne pouvez pas supprimer votre propre compte";
            $_SESSION['message_type'] = "error";
            header("Location: gere_users.php");
            exit();
        }
        try {
            $cnx->begin_transaction();
            $check = $cnx->prepare("SELECT id FROM user WHERE id = ?");
            $check->bind_param("i", $id);
            $check->execute();
            $check->store_result();
            if ($check->num_rows === 0) {
                throw new Exception("Utilisateur introuvable");
            }
            $check->close();
            $delete_recettes = $cnx->prepare("DELETE FROM recetts WHERE user_id = ?");
            if (!$delete_recettes) throw new Exception("Erreur préparation recettes : " . $cnx->error);
            $delete_recettes->bind_param("i", $id);
            $delete_recettes->execute();
            $delete_recettes->close();
            $delete_user = $cnx->prepare("DELETE FROM user WHERE id = ?");
            if (!$delete_user) throw new Exception("Erreur préparation user : " . $cnx->error);
            $delete_user->bind_param("i", $id);
            $delete_user->execute();
            $cnx->commit();
            $_SESSION['message'] = "Utilisateur et données supprimés avec succès";
            $_SESSION['message_type'] = "success";
        } catch (Exception $e) {
            $cnx->rollback();
            $_SESSION['message'] = "Erreur : " . $e->getMessage();
            $_SESSION['message_type'] = "error";
        }
        header("Location: gere_users.php");
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $errors = [];
    if (empty($username)) $errors[] = "Le nom est obligatoire";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
    if (!in_array($role, ['admin', 'utilisateur'])) $errors[] = "Rôle invalide";
    if ($action === 'add' && (empty($_POST['password']) || strlen($_POST['password']) < 6)) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
    }
    if (!empty($errors)) {
        $_SESSION['message'] = implode("<br>", $errors);
        $_SESSION['message_type'] = "error";
        header("Location: gere_users.php");
        exit();
    }
    try {
        if ($action === 'add') {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $cnx->prepare("INSERT INTO user (nom, mail, pass, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $password, $role);
        } else {
            $user_id = intval($_POST['user_id']);
            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $stmt = $cnx->prepare("UPDATE user SET nom=?, mail=?, pass=?, role=? WHERE id=?");
                $stmt->bind_param("ssssi", $username, $email, $password, $role, $user_id);
            } else {
                $stmt = $cnx->prepare("UPDATE user SET nom=?, mail=?, role=? WHERE id=?");
                $stmt->bind_param("sssi", $username, $email, $role, $user_id);
            }
        }
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution : " . $stmt->error);
        }
        $_SESSION['message'] = ($action === 'add') 
            ? "Utilisateur créé avec succès" 
            : "Mise à jour réussie";
        $_SESSION['message_type'] = "success";
    } catch (Exception $e) {
        $_SESSION['message'] = "Erreur : " . $e->getMessage();
        $_SESSION['message_type'] = "error";
    } finally {
        if (isset($stmt)) $stmt->close();
    }
    header("Location: gere_users.php");
    exit();
}
header("Location: gere_users.php");
exit();
?>