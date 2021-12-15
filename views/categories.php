<?php
session_start();
require "../functions/function.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php require "requires/require_meta.php";?>
    <title>Catégories</title>
</head>
<body>
    <header>
     <?php require "requires/require_header.php";?>
    </header>
    <main class="section_article">
        <h3>Nos catégories</h3>
        <section class="content_all_cats_categories">
            <?php
            $categories = select_all_categories_BDD();
            $i= 0;
            while (isset($categories[$i])){
            ?>
                <a class="<?=$categories[$i]['style']?>_a_background_categories" href="articles.php?categories=<?=$categories[$i]['id']?>">
                <div class="head_selesct_categories">
                    <i class="fas fa-tag"></i><h3><?=$categories[$i]['nom']?></h3>
                </div>
                <div class="content_img_categories">
                    <img src="../assets/img/photo_categories/photo_categorie<?=$categories[$i]['id']?>.jpg" alt="acceder à la catégorie : <?=$categories[$i]['nom']?>">
                </div>
                <div class="footer_select_cotegories">
                    <h4><?=$categories[$i]['accroche']?></h4>
                    <p><?=$categories[$i]['descriptif']?></p>
                </div>
                </a>

            <?php
            $i++;
            }
            ?>
        </section>
    </main>
    <footer>
    <?php require "requires/require_footer.php";?>
    </footer>
</body>
</html>