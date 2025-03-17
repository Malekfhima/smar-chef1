<?php
include("cnx.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    $req = mysqli_query($cnx, "SELECT nom FROM user WHERE nom='$username'");
    $nb = mysqli_num_rows($req);
    if ($nb > 0) {
        echo "<script>alert('Ce compte est déjà existant !!!');</script>";
        sleep(1);
        header('Location: ../index.php');
        exit();
    } else {
        $req1 = mysqli_query($cnx, "INSERT INTO user (nom, mail, pass) VALUES ('$username', '$email', '$password')");
        if ($req1) {
            echo "<script>alert('Inscription réussie !');</script>";
            sleep(1);
            header("Location: ../connexion.php");
            exit();
        } else {
            echo "<script>alert('Erreur lors de l\'inscription.');</script>";
        }
    }

    mysqli_close($cnx);
}
?>