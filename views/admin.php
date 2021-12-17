<?php
session_start();
require "../functions/function.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "requires/require_meta.php" ?>
    <title>Administrateur</title>
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
            recup_all_articles_admin() ;
            recup_all_categorie_admin();
            recup_all_users_admin() 
            ?>
            
        </section>
    </main>

    <?php
        require "requires/require_Footer.php";
    ?>
</body>
</html>