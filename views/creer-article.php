<?php
session_start();
echo $_SESSION['id'];
require "requires/require_Header.php";

require "../functions/function.php";


?>
<main>
<form action="creer-article.php"method="POST" enctype="multipart/form-data">
        <select name="categorie" >
        <?php affiche_categorie() ?>
        </select>
        <input type="text" name="titre" placeholder="titre article">
        <input type="text" name="description" placeholder="introduction article">
        <input type="file" name="avatar" id="avatar">
        <textarea name="article" cols="30" rows="10"></textarea>
        <input type="submit" name="creer">
        <?php creer_article()?>
    </form>
</main>
<?php

require "requires/require_Footer.php";
?>