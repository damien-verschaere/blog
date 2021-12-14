<?php
session_start();
require "../functions/function.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "requires/require_meta.php" ?>
    <title>Articles</title>
</head>
<body>
    <header>
        <?php 
            require "requires/require_Header.php";
        ?>
    </header>
    <main class="main_center">
        <section class="section_article">
            
            <?php
                affiche_self_article();
                affiche_commentaires_article();
            ?>
            
        </section>
    </main>

    <?php
        require "requires/require_Footer.php";
    ?>
</body>
</html>