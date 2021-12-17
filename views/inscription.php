<?php
session_start();


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
 <main class="section_article">
        <form action="inscription.php" method="post" class="form_inscription">
            <input type="text" placeholder="login" name=login>
            <input type="email" placeholder="email" name="email">
            <input type="password" placeholder="password" name="password">
            <input type="password" placeholder="confirm password" name="password2">
            <input type="submit" name="inscription">
            <?php inscription()?>
        </form>
    </main>
    <footer>
        <?php require "requires/require_Footer.php";?>
    </footer>
 </body>
 </html>   
    
