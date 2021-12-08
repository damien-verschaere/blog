<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <title>Document</title>
</head>
<body>
    <?php
        if (isset($_SESSION['login'])){
    ?>
    <header>
        <h1>Beblog</h1>
        <nav>
            <ul>
                <li><a href="../index.php"> Accueil </a></li>
                <li><a href="articles.php"> Articles </a></li>
                <li><a href="profil.php">Mon profil</a></li>
                <li><a href="creer-article.php"> Créer article </a></li>
                <li><a href="requires/deconnexion.php"> Deconnexion </a></li>
            </ul>
        </nav>
    </header>
    <?php
        }
        if (!isset($_SESSION['login'])){
    ?>
    <header>
        <h1>Beblog</h1>
        <nav>
            <ul>
                <li><a href="../index.php"> Accueil </a></li>
                <li><a href="inscription.php"> Inscription </a></li>
                <li><a href="connexion.php"> Connexion </a></li>
                <li><a href="articles.php"> Articles </a></li>
            </ul>
        </nav>
    </header>
    <?php 
        } 
    ?>
