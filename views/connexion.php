<?php
session_start();
require "../functions/function.php";


verif_user_connexion();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require "requires/require_meta.php" ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <header>
    <?php require "requires/require_header.php";?>
    </header>
    <main>
        <form class="form_connexion" action="" method="post">
        <label for="login">Login</label></br>
        <input type="text" name="login" placeholder="Login">
        <br>

        <label for="password">Password</label></br>
        <input type="password" name="password" placeholder="Password">
        </br><br>
        
        <input type="submit" name="submit_connexion" value="Connexion">
        </form>
    </main>
    <footer>
        <?php require "requires/require_Footer.php" ?>
    </footer>
</body>
</html>
<h2 class="titre_connexion">Beblog</h2>