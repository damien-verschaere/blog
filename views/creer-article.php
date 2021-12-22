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
        <section class="section_articles">
            <form action="creer-article.php" method="POST" enctype="multipart/form-data" class="form_inscription">
                <select name="categorie">
                    <?php affiche_categorie() ?>
                </select>
                <input type="text" name="titre" placeholder="titre article">
                <input type="text" name="description" placeholder="introduction article">
                <input type="file" name="image_article">
                <textarea name="article" cols="30" rows="10"></textarea>
                <input type="submit" name="creer">
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