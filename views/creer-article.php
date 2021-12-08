<?php
session_start();

require "requires/require_Header.php";
require "../functions/function.php";


?>
<main>
    <form action="creer-article.php"method="POST">
        <?php creer_article() ?>
        <input type="text" name="titre">
        <input type="text" name="description">
        <textarea name="article" cols="30" rows="10"></textarea>

    </form>
</main>
<?php

require "requires/require_Footer.php";
?>