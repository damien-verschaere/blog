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
        <h3 class="titre_articles">Les derniers articles <i class="fas fa-newspaper"></i></h3>
        <section class="section_accueil">
            <?php affiche_article()  ?>
        </section>
        <h3 class="titre_articles2">Les articles les plus commentés <i class="fas fa-fire"></i></h3>
        <section class="section_accueil">
            <?php affiche_article_com() ?>
        </section>
    </main>
    <?php require "requires/require_footer.php";?>
</body>
</html>