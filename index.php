<?php
session_start();
require('functions/function.php');
require "views/requires/require_Header.php";
?>

    <main>
        <div class=com>
            <a href="views/accueil.php">accueil</a>
        <?php affiche_article() ?>
        </div>
    </main>

