<?php
session_start();
require "../functions/function.php";
echo $_SESSION['id'];
require "requires/require_meta.php";
require "requires/require_Header.php";
?>
<main class="">
    <form action="creer-article.php"method="POST" enctype="multipart/form-data" class="form_creer_article">
        <select name="categorie" >
        <?php affiche_categorie() ?>
        </select>
        <input class="input_creer_article" type="text" name="titre" placeholder="titre article">
        <input class="input_creer_article" type="text" name="description" placeholder="introduction article">
        <input class="input_creer_article" type="file" name="image_article" id="image_article">
        <textarea class="input_creer_article" name="article" cols="30" rows="10"></textarea>
        <input class="input_creer_article" type="submit" name="creer">
        <?php creer_article()?>
    </form>
</main>
<?php

require "requires/require_Footer.php";
?>