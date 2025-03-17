<?php
include("cnx.php");
session_start();
$_SESSION['id']='';
$_SESSION['nom']='';
extract($_POST);
$req=mysqli_query($cnx,"SELECT * from user where nom='$username' and pass='$password'");
$nb=mysqli_num_rows($req);
if($nb> 0){
    $row = mysqli_fetch_array($req);
    $_SESSION['id'] = $row['id'];
    $_SESSION['nom'] = $row['nom'];
    echo"
    <script>alert('Connexion réussie !!!');</script>
    ";
    sleep(1);
    header("Location: ../index1.php");
}elseif($nb==0){
    echo"
    <script>alert('Nom dutilisateur ou mot de passe incorrect !!!');</script>
    ";
    $_SESSION['id'] = '';
    $_SESSION['nom'] = '';
    sleep(1);
    header("Location: ../connexion.php");
    exit();
}
?>