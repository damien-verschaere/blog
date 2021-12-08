<?php

session_start();

require "requires/require_Header.php";

require "../functions/function.php";

verif_user_connexion();

?>

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



<?php
require "requires/require_Footer.php";
?>