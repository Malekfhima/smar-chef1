<?php
session_start();
include("cnx.php");
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Accès non autorisé']);
    exit();
}
if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $cnx->prepare("SELECT id, nom, mail, role FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'Utilisateur introuvable']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'ID utilisateur manquant']);
}
?>