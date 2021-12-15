<?php
session_start();
require "../functions/function.php";


verif_user_connexion();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "requires/require_meta.php" ?>
    <title>Document</title>
</head>
<body>
    <header>
        <?php
            require "requires/require_Header.php"
        ?>
    </header>
    <main>
        <section class="section_article">
    <h2 class="titre_connexion">Beblog</h2>


    <form class="form_connexion" action="" method="post">
    <label for="login">Login</label></br>
    <input type="text" name="login" placeholder="Login">
    <br>

    <label for="password">Password</label></br>
    <input type="password" name="password" placeholder="Password">
    </br><br>
    
    <input type="submit" name="submit_connexion" value="Connexion">
    </form> 
        </section>
    </main>
</body>
</html>





<?php
require "requires/require_Footer.php";
?>
