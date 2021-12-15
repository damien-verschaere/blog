<?php
session_start();
require "../functions/function.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
     <?php require "requires/require_meta.php";?>
    <title>Document</title>
</head>
<body>
    <header>
     <?php require "requires/require_Header.php";?>
    </header>
    <main class="accueil">
        <?php affiche_article();?>
    </main>
    <footer>
    <?php require "requires/require_Footer.php";?>
    </footer>
</body>
</html>

