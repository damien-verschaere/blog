<?php
session_start();
$img_utilisateur="../assets/img/beblog_logo_icon.png";

require "../functions/function.php";

?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <?php require "requires/require_meta.php"?>
 </head>
 <body>
     <header>
        <?php require "requires/require_Header.php"; ?>
     </header>
 <main >
     <div class="main_inscription">
         <section class="section_article_inscription">
            <form action="inscription.php" method="post" class="form_inscription">
                <h2 class="titre_inscription">Inscription</h2>
                <input class="inscription_login" type="text" placeholder="Login" name=login>
                <input class="inscription_email" type="email" placeholder="E-mail" name="email">
                <input class="inscription_password" type="password" placeholder="Password" name="password">
                <input class="inscription_password2" type="password" placeholder="Confirm password" name="password2">
                <input type="hidden" name="icon" value= <?php $img_utilisateur ?> >
                <input class="sub_inscription" type="submit" name="inscription" value="Inscription">
            <?php
             inscription();
             info_barre();
            ?>

            </form>
         </section>
    </div>
</main>
    <footer>
        <?php require "requires/require_Footer.php";?>
    </footer>
 </body>
 </html>   
    
