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
        <form action="inscription.php" method="post" class="form_inscription">
            <input class="inscription_login" type="text" placeholder="login" name=login>
            <input class="inscription_email" type="email" placeholder="email" name="email">
            <input class="inscription_password" type="password" placeholder="password" name="password">
            <input class="inscription_password2" type="password" placeholder="confirm password" name="password2">
            <input type="hidden" name="icon" value= <?php $img_utilisateur ?> >
            <input class="sub_inscription" type="submit" name="inscription" value="inscription">
            <?php
             inscription();
             info_barre();
            ?>

        </form>
        </div>
    </main>
    <footer>
        <?php require "requires/require_Footer.php";?>
    </footer>
 </body>
 </html>   
    
