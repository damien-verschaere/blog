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
        <section class="section_articles_affiche">
            <form class="form_articles" method="get" action="">
                <?php
                    affiche_all_articles();
                ?>
            </form>
        </section>
    </main>

<?php
require "requires/require_Footer.php";
?>
</body>
</html>