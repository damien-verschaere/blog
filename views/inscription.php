<?php
session_start();
require "../functions/function.php";



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php require "requires/require_meta.php" ?>
    <title>Inscription</title>
</head>
<body>
    <header>
    <?php require "requires/require_header.php";?>
    </header>
    <main class="section_inscription">
        <form action="inscription.php" method="post" class=form_inscription>
            <input class="input_inscription" type="text" placeholder="login" name=login>
            <input class="input_inscription" type="email" placeholder="email" name="email">
            <input class="input_inscription" type="password" placeholder="password" name="password">
            <input class="input_inscription" type="password" placeholder="verivication password" name="password2">
            <input class="input_inscription" type="submit" name="inscription">
            <?php inscription()?>
        </form>
    </main>
    <footer>
        <?php require "requires/require_Footer.php" ?>
    </footer>
    </body>
</html>