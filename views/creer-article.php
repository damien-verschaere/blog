<?php
session_start();
echo $_SESSION['id'];
require "requires/require_Header.php";
require "../functions/function.php";


?>
<main>
    <form action="creer-article.php"method="POST" >
        <select name="categorie" >
        <?php affiche_categorie() ?>
        </select>
        <input type="text" name="titre" placeholder="titre article">
        <input type="text" name="description" placeholder="introduction article">
        <textarea name="article" cols="30" rows="10"></textarea>
        <input type="submit" name="creer">
        <?php creer_article()?>
    </form>
    <form action="creer-article.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image_article" id="image_article">
        <input type="submit" name="send_image">
        <?php image() ?>
    </form>
</main>
<?php

require "requires/require_Footer.php";
?>