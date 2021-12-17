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
    <header>
     <?php require "requires/require_header.php";?>
    </header>
    <main class="section_article">
        <section>
            <?php affiche_article() ?>
        </section>
    </main>
    <footer>
    <?php require "requires/require_footer.php";?>
    </footer>
</body>
</html>