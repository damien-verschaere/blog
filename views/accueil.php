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
   
     <?php require "requires/require_header.php";?>
      
    <main class="section_article">
        <h3>LES DERNIERS ARTICLES </h3>
        <section class="section_accueil">
            <?php affiche_article() ?>
        </section>
        <h3>LES ARTICLES LES PLUS COMMENTES</h3>
        <section class="section_accueil">
            <?php affiche_article_com() ?>
        </section>
    </main>
    <?php require "requires/require_footer.php";?>
</body>
</html>