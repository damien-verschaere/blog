<?php
session_start();

require "../functions/function.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "requires/require_meta.php" ?>
    <title>Créer-article</title>
</head>

<body>
    <header>
        <?php require "requires/require_Header.php" ?>
    </header>
    <main class="main_center">
        <section class="section_article">
            <form action="creer-article.php" method="POST" enctype="multipart/form-data" class="form_inscription">
            <h2 class="titre_creer_article">Créer un article</h2>
                <select class="select_article" name="categorie">
                    <?php affiche_categorie(); ?>
                </select>
                <input class="titre_article" type="text" name="titre" placeholder="titre article">
                <input class="introduction_article" type="text" name="description" placeholder="introduction article">
                <label for="image_article">Ajouter une image : 
                <input id="image_article" class="image_article" type="file" name="image_article">
                </label>
                <textarea class="area_article" name="article" cols="60" rows="10" placeholder="Contenu de l'article"></textarea>
                <input class="sub_inscription" type="submit" name="creer">
                <?php 
                creer_article();
                info_barre();
                ?>
            </form>
            </div>
        </section>
    </main>
    <?php

    require "requires/require_Footer.php";
    ?>
</body>