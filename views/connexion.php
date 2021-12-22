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
        <section class="section_article_connexion"> 
            <div class="bloc_connexion">
                <h2 class="titre_connexion">Connexion</h2>

                <form class="form_connexion" action="" method="post">
                    <label for="login">Login</label></br>
                    <input class="input_connexion" type="text" name="login" placeholder="Login">
                    <br>

                    <label for="password">Password</label></br>
                    <input class="input_connexion" type="password" name="password" placeholder="Password">
                    </br><br>
    
                    <input class="submit_connexion" type="submit" name="submit_connexion" value="Connexion">
                    </form> 
            </div>
        </section>
        
    </main>
</body>
</html>





<?php
require "requires/require_Footer.php";
?>
