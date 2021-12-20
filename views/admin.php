<?php
session_start();
require "../functions/function.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "requires/require_meta.php"?>
    <title>Administrateur</title>
</head>
<body>
    <header>
        <?php require "requires/require_Header.php";?>
    </header>
    <main class="main_center">
        <section class="section_articles">
            <?php 
            infos_blog_admin();

                if (isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
            all_articles_admin()
            ?>
        </section>
    </main>

    <?php
        require "requires/require_Footer.php";
    ?>
</body>
</html>